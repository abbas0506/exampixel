<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Paper;
use App\Models\User;
use Illuminate\Http\Request;

class UserPaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        $user = User::findOrFail($id);
        $papers = $user->papers;
        return view('admin.user-papers.index', compact('user', 'papers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show($userId, string $id)
    {
        //
        $paper = Paper::findOrFail($id);
        $user = User::findOrFail($userId);
        $chapterNos = Chapter::whereIn('id', $paper->chapterIdsArray())->pluck('sr')->implode(',');
        return view('admin.user-papers.show', compact('paper', 'user', 'chapterNos'));
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
