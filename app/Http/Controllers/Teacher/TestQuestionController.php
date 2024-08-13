<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\TestQuestionPart;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestQuestionController extends Controller
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
    public function add($testId, $questionType)
    {
        //
        if (session('chapterNoArray')) {
            $test = Test::find($testId);
            $chapters = Chapter::whereIn('id', session('chapterNoArray'))->get();
            return view('teacher.tests.questions.create', compact('test', 'chapters', 'questionType'));
        } else {
            echo "Chapters not selected!";
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate request parameters
        $request->validate([
            'test_id' => 'required|numeric',
            'question_type' => 'required',
            'necessary_parts' => 'required|numeric',

            'chapter_id_array' => 'required',
            'num_of_parts_array' => 'required',
        ]);

        DB::beginTransaction();
        try {
            //create test question instance
            $testQuestion = TestQuestion::create([
                'test_id' => $request->test_id,
                'question_no' => $request->question_no,
                'question_type' => $request->question_type,
                'necessary_parts' => $request->necessary_parts,
            ]);
            //randomly select question parts from each chapter and save them
            $chaperIds = array();
            $numOfParts = array();
            $chaperIds = $request->chapter_id_array;
            $numOfParts = $request->num_of_parts_array;
            $chapters = Chapter::whereIn('id', $chaperIds)->get();

            $i = 0;     //for iterating numOfparts


            foreach ($chapters as $chapter) {
                $questions = Question::where('question_type', $request->question_type)
                    ->where('chapter_id', $chapter->id)
                    ->where('bise_frequency', '>', 1)
                    ->get()
                    ->random($numOfParts[$i++]);
                foreach ($questions as $question) {
                    TestQuestionPart::create([
                        'test_question_id' => $testQuestion->id,
                        'question_id' => $question->id,
                        'marks' => $question->marks,
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('teacher.tests.show', $request->test_id)->with('success', 'Question successfully added!');
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
