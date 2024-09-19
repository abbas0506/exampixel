<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\PaperQuestion;
use App\Models\PaperQuestionPart;
use App\Models\Question;
use Exception;
use Illuminate\Http\Request;

class AlternativeLongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        //
        $paperQuestion = PaperQuestion::find($id);
        $paper = $paperQuestion->paper;
        $chapters = Chapter::whereIn('id', session('chapterIdsArray'))->get();
        return view('user.paper-questions.longs.alternative', compact('paperQuestion', 'paper', 'chapters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        //
        $request->validate([
            'frequency' => 'required|numeric',
            'chapter_id' => 'required',
        ]);

        try {
            $paperQuestion = PaperQuestion::find($id);
            //randomly select question parts from each chapter and save them
            $threshold = $request->frequency;

            $question = Question::where('type_id', 3)
                ->where('chapter_id', $request->chapter_id)
                ->where('frequency', '>=', $threshold)
                ->get()
                ->random(1)
                ->first();

            $paperQuestion->paperQuestionParts()->create([
                'paper_question_id' => $paperQuestion->id,
                'question_id' => $question->id,
            ]);

            // echo $question->id;
            return redirect()->route('user.papers.show', $paperQuestion->paper)->with('success', 'Question successfully added!');
        } catch (Exception $e) {

            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
