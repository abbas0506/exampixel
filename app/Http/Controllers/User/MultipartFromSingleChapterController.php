<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use App\Models\PaperQuestionPart;
use App\Models\Question;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;

class MultipartFromSingleChapterController extends Controller
{
    //
    public function store(Request $request, $id)
    {
        $request->validate([
            'question_type' => 'required',
            'question_title' => 'nullable',
            'frequency' => 'required|numeric',
            'chapter_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            //create test question instance
            $paper = Paper::find($id);
            $paperQuestion = $paper->paperQuestions()->create([
                'question_type' => $request->question_type,
                'question_title' => $request->question_title,
                'frequency' => $request->frequency,
                'choices' => $request->choices,
            ]);
            //randomly select question parts from each chapter and save them
            $threshold = $request->frequency;

            // if multipart long question
            if ($request->num_of_parts) {
                $numOfParts = $request->num_of_parts;
                $questions = Question::where('type_id', 3)
                    ->where('chapter_id', $request->chapter_id)
                    ->where('frequency', '>=', $threshold)
                    ->get()
                    ->random($numOfParts);

                // if there are more than one questions selected
                foreach ($questions as $question) {
                    PaperQuestionPart::create([
                        'paper_question_id' => $paperQuestion->id,
                        'question_id' => $question->id,
                        'marks' => $request->marks,
                    ]);
                }
            } else {

                // long question: single part
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
            }

            dB::commit();
            // echo $question->id;
            return redirect()->route('user.papers.show', $paper)->with('success', 'Question successfully added!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
