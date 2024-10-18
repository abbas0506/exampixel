<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Paper;
use App\Models\PaperQuestionPart;
use App\Models\Question;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NumberFormatter;

class PartialQuestionController extends Controller
{
    //

    public function create($paperId, $typeId)
    {

        $paper = Paper::findOrFail($paperId);
        //send only type-relevant chapters  
        $chapterIds = Question::where('type_id', $typeId)->whereIn('chapter_id', $paper->chapterIdsArray())->pluck('chapter_id')->unique();
        $chapters = Chapter::whereIn('id', $chapterIds)->get();

        $type = Type::findOrFail($typeId);
        return view('user.paper-questions.partial.create', compact('paper', 'chapters', 'type'));
    }


    public function store(Request $request, $paperId, $typeId)
    {
        //
        $request->validate([
            'marks' => 'required|numeric',
            'frequency' => 'required|numeric',
            'compulsory_parts' => 'required|numeric|min:1',
            'chapter_ids_array' => 'required',
            'num_of_parts_array' => 'required',
        ]);

        DB::beginTransaction();
        try {
            //create test question instance
            $paper = Paper::findOrFail($paperId);
            $question_title = $request->question_title;

            $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);


            if ($request->compulsory_parts < collect($request->num_of_parts_array)->sum())
                $question_title = $request->question_title . " ( any " .  $formatter->format($request->compulsory_parts) . ")";

            if ($typeId == 1 || $typeId == 30) //mcqs
                $marks = $request->compulsory_parts;
            elseif ($typeId == 2 || $typeId == 31) //short
                $marks = $request->compulsory_parts * 2;
            else
                $marks = $request->marks;

            $paperQuestion = $paper->paperQuestions()->create([
                'question_title' => $question_title,
                'type_name' => $request->type_name,
                'frequency' => $request->frequency,
                'compulsory_parts' => $request->compulsory_parts,
                'marks' => $marks,
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
                $questions = Question::where('type_id', $typeId)
                    ->where('chapter_id', $chapter->id)
                    ->where('frequency', '>=', $threshold)
                    ->get()
                    ->random($numOfParts[$i++]);

                foreach ($questions as $question) {
                    PaperQuestionPart::create([
                        'paper_question_id' => $paperQuestion->id,
                        'question_id' => $question->id,
                        'marks' => $request->marks,
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
