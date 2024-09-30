<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use App\Models\PaperQuestionPart;
use App\Models\Question;
use Exception;
use Illuminate\Http\Request;

class SimpleQuestionController extends Controller
{
    public function store(Request $request, $id)
    {
        //
        $request->validate([
            'question_type' => 'required',
            'question_title' => 'nullable',
            'frequency' => 'required|numeric',
            'chapter_id' => 'required',
        ]);

        try {
            //create test question instance
            $paper = Paper::find($id);
            $question_title = '';
            $paperQuestion = $paper->paperQuestions()->create([
                'question_type' => $request->question_type,
                'question_title' => $request->question_title,
                'frequency' => $request->frequency,
                'choices' => 0,
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
            return redirect()->route('user.papers.show', $paper)->with('success', 'Question successfully added!');
        } catch (Exception $e) {

            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
