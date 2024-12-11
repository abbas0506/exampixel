<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Profile;
use App\Models\Question;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return view('admin.dashboard', compact('profiles', 'grades', 'questions', 'users', 'questionStat'));
    }
}
