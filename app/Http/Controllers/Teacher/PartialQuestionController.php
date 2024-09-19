<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Paper;
use App\Models\PaperQuestionPart;
use App\Models\Question;
use Exception;
use Illuminate\Http\Request;

class PartialQuestionController extends Controller
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
        if (session('chapterIdsArray')) {
            $paper = Paper::find($id);
            $chapters = Chapter::whereIn('id', session('chapterIdsArray'))->get();
            return view('teacher.paper-questions.longs.partial', compact('paper', 'chapters'));
        } else {
            echo "Chapters not selected!";
        }
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
            //create test question instance
            $paper = Paper::find($id);
            $question_title = '';
            $paperQuestion = $paper->paperQuestions()->create([
                'type_id' => 3,
                'question_title' => '',
                'frequency' => $request->frequency,
                'choices' => 0,
                'question_nature' => 'partial'
            ]);
            //randomly select question parts from each chapter and save them
            $i = 0; //for iterating numOfparts
            $threshold = $request->frequency;


            $question = Question::where('type_id', 3)
                ->where('chapter_id', $request->chapter_id)
                ->where('frequency', '>=', $threshold)
                ->get()
                ->random(1)
                ->first();


            PaperQuestionPart::create([
                'paper_question_id' => $paperQuestion->id,
                'question_id' => $question->id,
                'marks' => $request->marks,
            ]);

            // echo $question->id;
            return redirect()->route('teacher.papers.show', $paper)->with('success', 'Question successfully added!');
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
