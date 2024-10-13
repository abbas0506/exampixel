<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Paper;
use App\Models\PaperQuestion;
use App\Models\PaperQuestionPart;
use App\Models\Question;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rmunate\Utilities\SpellNumber;
use NumberFormatter;


class PaperQuestionController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $paperId)
    {
        //
        $request->validate([
            'type_id' => 'required|numeric',
            'subtype_id' => 'nullable|numeric',
            'question_title' => 'nullable|max:100',
            // 'question_nature' => 'required',
            // 'exercise_ratio' => 'required|numeric',
            // 'conceptual_ratio' => 'required|numeric',
            'frequency' => 'required|numeric',
            'choices' => 'required|numeric',
            // 'number_style' => 'required',
            // 'display_cols' => 'required|numeric',
            // 'position' => 'required|numeric',
            'chapter_ids_array' => 'required',
            'parts_count_array' => 'required',

        ]);

        $paper = Paper::findOrFail($paperId);
        DB::beginTransaction();

        $question_title = '';
        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        if ($request->type_id == 1) {
            $mustAttempt = collect($request->parts_count_array)->sum() - $request->choices;


            $question_title = "Attempt any " . $formatter->format($mustAttempt) . " questions.";
        }


        try {
            //create paper question instance
            $paperQuestion = $paper->paperQuestions()->create([
                'type_id' => $request->type_id,
                'question_title' => $question_title,
                'question_nature' => $request->question_nature ? $request->question_nature : 'compact',
                // 'exercise_ratio' => $request->exercise_ratio,
                // 'conceptual_ratio' => $request->conceptual_ratio,
                'frequency' => $request->frequency,
                'choices' => $request->choices,
                // 'number_style' => $request->num,
                // 'display_cols' => 'required|numeric',
                // 'position' => 'required|numeric',
            ]);
            //randomly select question parts from each chapter and save them
            $chaperIds = array();
            $partsCount = array();
            $chaperIds = $request->chapter_ids_array;
            $partsCount = $request->parts_count_array;
            $chapters = Chapter::whereIn('id', $chaperIds)->get();

            $i = 0; //for iterating numOfparts
            // echo $threshold;

            foreach ($chapters as $chapter) {

                if ($request->subtype_id) {
                    $randomQuestions = Question::where('type_id', $request->type_id)
                        ->where('subtype_id', $request->subtype_id)
                        ->where('chapter_id', $chapter->id)
                        // ->where('is_from_exercise', $request->exercise_only)
                        ->where('frequency', '>=', $request->frequency)
                        ->get()
                        ->random($partsCount[$i]);
                } else {
                    $randomQuestions = Question::where('type_id', $request->type_id)
                        ->where('chapter_id', $chapter->id)
                        // ->where('is_from_exercise', $request->exercise_only)
                        ->where('frequency', '>=', $request->frequency)
                        ->get()
                        ->random($partsCount[$i]);
                }

                foreach ($randomQuestions as $question) {
                    $paperQuestion->paperQuestionParts()->create([
                        'question_id' => $question->id,
                    ]);
                }

                $i++;
            }
            DB::commit();
            // print_r($chaperIds);
            return redirect()->route('collaborator.papers.show', $paper)->with('success', 'Question successfully added!');
        } catch (Exception $e) {
            DB::rollBack();
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
    public function destroy(string $paperId, $paperQuestionId)
    {
        //
        try {
            $paperQuestion = PaperQuestion::findOrFail($paperQuestionId);
            $paperQuestion->delete();
            return redirect()->back()->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
