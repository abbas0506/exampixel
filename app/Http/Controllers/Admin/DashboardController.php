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
            'labels' => ['All', 'Active', 'Potential', 'Recent'],
            'values' => [
                $allUsers->count(),
                $activeUsers->count(),
                $potentialUsers->count(),
                $recentUsers->count(),
            ],
            'colors' => ['teal', 'orange', 'blue', 'green']
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

        $fourWeeksAgo = Carbon::now()->subWeeks(4);

        // Fetch data
        $topUsers = DB::table('papers')
            ->selectRaw('user_id, YEAR(created_at) as year, WEEK(created_at) as week, COUNT(*) as paper_count')
            ->where('created_at', '>=', $fourWeeksAgo)
            ->groupBy('user_id', 'year', 'week')
            ->orderBy('week')
            // ->limit(20)
            ->having('paper_count', '>', 2)
            ->get();

        $chartData = [];
        $users1 = DB::table('users')->whereIn('id', $topUsers->pluck('user_id'))->get();

        foreach ($users1 as $user) {
            $userWeeklyData = $topUsers->where('user_id', $user->id);

            $chartData[] = [
                'label' => $user->name,
                'data' => $userWeeklyData->pluck('paper_count'),
                'borderColor' => '#' . substr(md5(rand()), 0, 6), // Random color
                'fill' => false,
            ];
        }

        // x-axis labels (weeks)
        $weeks = $topUsers->groupBy('week')->keys()->toArray();

        // print_r($chartData);
        return view('admin.dashboard', compact('profiles', 'grades', 'questions', 'users', 'questionStat', 'paperCount', 'weeks', 'chartData'));
    }
}
