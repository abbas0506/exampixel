<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        //
        $subjectId = Auth::user()->profile->subject_id;

        $questions = Question::whereRelation('chapter', function ($query) use ($subjectId) {
            $query->whereRelation('book', function ($query) use ($subjectId) {
                $query->where('subject_id', $subjectId);
            });
        })->get();

        return view('collaborator.dashboard', compact('questions'));
    }
}
