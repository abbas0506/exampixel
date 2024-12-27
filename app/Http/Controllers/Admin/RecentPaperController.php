<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RecentPaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $recentPapers = Paper::whereDate('created_at', Carbon::today())->get();
        return view('admin.recent-papers.index', compact('recentPapers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function summary()
    {
        //
        $today = Carbon::today();
        $users = User::withCount(['papers as paper_count' => function ($query) use ($today) {
            $query->whereDate('created_at', $today);
        }])
            ->having('paper_count', '>', 0) // Include only users who created papers today
            ->get();
        $paperCount = Paper::whereDate('created_at', $today)->count();
        return view('admin.recent-papers.summary', compact('users', 'paperCount'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $paper = Paper::find($id);
        return view('admin.recent-papers.show', compact('paper'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
