<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Paper;
use App\Models\Profile;
use App\Models\Question;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $profiles = Profile::all();
        $grades = Grade::all();
        $questions = Question::all();
        $allUsers = User::all();

        $recentUsers = User::withCount('papers')
            ->having('papers_count', '>', 0)
            ->whereDate('created_at', today())
            ->get();

        $activeUsers = User::withCount('papers')
            ->having('papers_count', '>', 5)
            ->whereDate('created_at', '!=', today())
            ->get();

        $potentialUsers = User::whereHas('papers', function ($query) {
            $query->selectRaw('DATE(created_at) as dt, user_id, COUNT(*) as paper_count')
                ->groupBy('dt', 'user_id')
                ->having('paper_count', '>', 5)
            ;
        })->get();

        $users = [
            'labels' => ['Active', 'Potential', 'Recent'],
            'values' => [
                $activeUsers->count(),
                $potentialUsers->count(),
                $recentUsers->count(),
            ],
            'colors' => ['teal', 'orange', 'blue']
        ];

        // question analysis
        $questions_9 = Grade::where('grade_no', 9)->first()->questions();
        $questions_10 = Grade::where('grade_no', 10)->first()->questions();
        $questions_11 = Grade::where('grade_no', 11)->first()->questions();
        $questions_12 = Grade::where('grade_no', 12)->first()->questions();
        $questionStat = [
            'labels' => ['9th', '10th', '11th', '12th'],
            'data' => [
                $questions_9->count(),
                $questions_10->count(),
                $questions_11->count(),
                $questions_12->count(),
            ],
            'colors' => ['red', 'green', 'orange', 'pink']
        ];

        $allPapersCount = Paper::all()->count();
        $recentPapersCount = Paper::whereDate('created_at', today())->count();
        $paperCount = [
            'all' => $allPapersCount,
            'recent' => $recentPapersCount,
        ];

        // Get the start of the current week
        $startOfWeek = Carbon::now()->startOfWeek();

        $fourWeeksAgo = Carbon::now()->subWeeks(8);

        // Fetch data
        $weeklyPaperCount = DB::table('papers')
            ->selectRaw('WEEK(created_at) as week, COUNT(*) as paper_count')
            ->where('created_at', '>=', $fourWeeksAgo)
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        $weeklyPapers = [
            'labels' => $weeklyPaperCount->pluck('week'),
            'data' => $weeklyPaperCount->pluck('paper_count'),
        ];

        // Get the start date for 15 days ago
        $startDate = Carbon::today()->subDays(14); // 15 days including today

        // Fetch the papers created in the last 15 days, grouped by the created_at date
        $papers = Paper::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, count(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $registered = User::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, count(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Prepare the dates and paper counts for the graph
        $dates = [];
        $paperCounts = [];

        // Define the weekday labels
        $weekdayLabels = ['S', 'M', 'T', 'W', 'T', 'F', 'S']; // Sunday to Saturday

        // Fill in the data, even for days with no papers (set count to 0)
        for ($i = 14; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->toDateString();
            $dates[] = $weekdayLabels[Carbon::parse($date)->dayOfWeek];  // Map to the weekday label (M, T, W...)
            $days[] = 15 - $i;
            // Find the paper count for the current date, if available
            $pCount = $papers->firstWhere('date', $date)->count ?? 0;
            $paperCounts[] = $pCount;

            $registeredCount = $registered->firstWhere('date', $date)->count ?? 0;
            $registeredCounts[] = $registeredCount;
        }

        // print_r($dates);
        // print_r($chartData);
        return view('admin.dashboard', compact('profiles', 'grades', 'paperCount', 'questions', 'users', 'questionStat', 'weeklyPapers', 'dates', 'paperCounts', 'days', 'registeredCounts'));
    }
}
