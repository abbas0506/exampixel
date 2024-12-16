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
use Illuminate\Database\Eloquent\Factories\Sequence;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = [
            'all' => User::count(),
            'recent' => User::whereDate('created_at', today())->count(),
        ];
        $questions = [
            'all' => Question::count(),
            'recent' => Question::whereDate('created_at', today())->count(),
        ];
        $papers = [
            'all' => Paper::count(),
            'recent' => Paper::whereDate('created_at', today())->count(),
        ];

        $newUsersCount = User::withCount('papers')
            ->having('papers_count', '>', 0)
            ->whereDate('created_at', today())
            ->count();

        $activeUsersCount = Paper::where('created_at', '>=', Carbon::now()->subDays(7))
            ->distinct('user_id')
            ->count('user_id');

        $passiveUsersCount = User::withCount('papers')
            ->having('papers_count',  0)
            ->count();

        $userRatio = [
            'labels' => ['New', 'Active', 'Passive'],
            'values' => [
                $newUsersCount,
                $activeUsersCount,
                $passiveUsersCount,
            ],
        ];

        $gradePapers = Grade::withCount(['papers'])
            ->get();

        $gradeWisePapers = [
            'labels' => $gradePapers->pluck('grade_no'),
            'paperCount' => $gradePapers->pluck('papers_count')
        ];

        //get papers generated during last 8 weeks
        $eightWeeksAgo = Carbon::now()->subWeeks(8);
        $weeklyPaperCount = DB::table('papers')
            ->selectRaw('WEEK(created_at) as week, COUNT(*) as paper_count')
            ->where('created_at', '>=', $eightWeeksAgo)
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        $weeklyUserCount = DB::table('users')
            ->selectRaw('WEEK(created_at) as week, COUNT(*) as user_count')
            ->where('created_at', '>=', $eightWeeksAgo)
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        $weeklyPapers = [
            'labels' => $weeklyPaperCount->pluck('week'),
            'paperCount' => $weeklyPaperCount->pluck('paper_count'),
            'userCount' => $weeklyUserCount->pluck('user_count'),
        ];

        // get papers and user count during last 15 days including today
        $startDate = Carbon::today()->subDays(14);

        $papersGenerated = Paper::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, count(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $registrations = User::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, count(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // create date labels
        $dates = [];
        $paperCount = [];
        $userCount = [];
        for ($i = 14; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i)->toDateString();
            $dates[] = Carbon::parse($day)->day;
            $paperCount[] = Paper::whereDate('created_at', $day)->count();
            $userCount[] = User::whereDate('created_at', $day)->count();
        }
        // pack the last 15 days data
        $last15Days = [
            'labels' => $dates,
            // 'paperCount' => $papersGenerated->pluck('count'),
            'paperCount' => $paperCount,
            // 'userCount' => $registrations->pluck('count'),
            'userCount' => $userCount,
        ];

        return view('admin.dashboard', compact('users', 'questions', 'papers', 'userRatio', 'gradeWisePapers', 'weeklyPapers', 'last15Days'));
    }
}
