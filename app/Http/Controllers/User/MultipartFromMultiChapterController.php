<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Paper;
use App\Models\PaperQuestionPart;
use App\Models\Question;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NumberFormatter;

class MultipartFromMultiChapterController extends Controller
{
    //
    public function store(Request $request, $id)
    {
        //
        $request->validate([
            'frequency' => 'required|numeric',
            'choices' => 'required|numeric',
            'chapter_ids_array' => 'required',
            'num_of_parts_array' => 'required',
        ]);

        DB::beginTransaction();
        try {
            //create test question instance
            $paper = Paper::find($id);

            $question_title = '';
            $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);

            $mustAttempt = collect($request->num_of_parts_array)->sum() - $request->choices;

            if ($request->choices == 0)

                $question_title = "Attempt all questions.";
            else
                $question_title = "Attempt any " . $formatter->format($mustAttempt) . " questions.";

            $paperQuestion = $paper->paperQuestions()->create([
                'question_type' => $request->question_type,   //1 for mcq, 2 for short
                'question_title' => $question_title,
                'frequency' => $request->frequency,
                'choices' => $request->choices,
            ]);

            //randomly select question parts from each chapter and save them
            $chaperIds = array();
            $numOfParts = array();
            $chaperIds = $request->chapter_ids_array;
            $numOfParts = $request->num_of_parts_array;
            $chapters = Chapter::whereIn('id', $chaperIds)->get();

            $i = 0; //for iterating numOfparts
            $threshold = $request->frequency;

            foreach ($chapters as $chapter) {
                // extract short question
                $questions = Question::where('type_id', $request->question_type)
                    ->where('chapter_id', $chapter->id)
                    ->where('frequency', '>=', $threshold)
                    ->get()
                    ->random($numOfParts[$i++]);

                foreach ($questions as $question) {
                    PaperQuestionPart::create([
                        'paper_question_id' => $paperQuestion->id,
                        'question_id' => $question->id,
                        'marks' => ($request->question_type == 1 ? 1 : 2),
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('user.papers.show', $paper)->with('success', 'Question successfully added!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
