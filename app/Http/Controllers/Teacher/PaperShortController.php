<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Paper;
use App\Models\PaperQuestionPart;
use App\Models\Question;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NumberFormatter;

class PaperShortController extends Controller
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
            return view('teacher.paper-questions.shorts.create', compact('paper', 'chapters'));
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
            'question_nature' => 'required',
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
                'type_id' => 2,
                'question_title' => $question_title,
                'frequency' => $request->frequency,
                'choices' => $request->choices,
                'question_nature' => $request->question_nature,
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
                $questions = Question::where('type_id', 2)
                    ->where('chapter_id', $chapter->id)
                    ->where('frequency', '>=', $threshold)
                    ->get()
                    ->random($numOfParts[$i++]);

                foreach ($questions as $question) {
                    PaperQuestionPart::create([
                        'paper_question_id' => $paperQuestion->id,
                        'question_id' => $question->id,
                        'marks' => $question->marks,
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('teacher.papers.show', $paper)->with('success', 'Question successfully added!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
        $request->validate([
            'choices' => 'required|numeric',
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
                'type_id' => 1,
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
                $questions = Question::where('type_id', 2)
                    ->where('chapter_id', $chapter->id)
                    ->where('frequency', '>=', $threshold)
                    ->get()
                    ->random($numOfParts[$i++]);

                foreach ($questions as $question) {
                    PaperQuestionPart::create([
                        'paper_question_id' => $paperQuestion->id,
                        'question_id' => $question->id,
                        'marks' => $question->marks,
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('teacher.papers.show', $paper)->with('success', 'Question successfully added!');
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
    public function destroy(string $id)
    {
        //
    }
}
