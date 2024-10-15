<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChapterQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($chapterId, $questionableType = null)
    {
        //
        $chapter = Chapter::findOrFail($chapterId);
        return view('operator.questions.index', compact('chapter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($chapterId, $questionableType)
    {
        //
        $chapter = Chapter::findOrFail($chapterId);
        $types = Type::all();

        return view('operator.questions.create', compact('chapter', 'types', 'questionableType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $chapterId)
    {
        //
        $request->validate([
            'statement' => 'required',
            'marks' => 'required|numeric',
            'exercise_no' => 'nullable|numeric',
            'frequency' => 'required|numeric',
            'is_conceptual' => 'required|boolean',
            'type_id' => 'required|numeric',
            'questionableType' => 'required|numeric|max:5',
        ]);

        $chapter = Chapter::findOrFail($chapterId);
        DB::beginTransaction();

        try {


            $question = $chapter->questions()->create([
                'user_id' => Auth::user()->id,
                'type_id' => $request->type_id,
                'statement' => $request->statement,
                'marks' => $request->marks,
                'exercise_no' => $request->exercise_no,
                'frequency' => $request->frequency,
                'is_conceptual' => $request->is_conceptual,
            ]);

            // mcqs
            if ($request->questionableType == 1) {
                $correct = '';
                if ($request->check_a) $correct = 'a';
                if ($request->check_b) $correct = 'b';
                if ($request->check_c) $correct = 'c';
                if ($request->check_d) $correct = 'd';

                $question->mcq()->create([
                    'choice_a' => $request->choice_a,
                    'choice_b' => $request->choice_b,
                    'choice_c' => $request->choice_c,
                    'choice_d' => $request->choice_d,
                    'correct' => $correct,
                ]);
            } elseif ($request->questionableType == 4) {
                // poetry: prarphrasing
                foreach ($request->poetry_lines as $poetry_line) {
                    if ($poetry_line != '')
                        $question->paraphrasings()->create([
                            'poetry_line' => $poetry_line,
                        ]);
                }
            } elseif ($request->questionableType == 5) {
                //comprehension
                foreach ($request->sub_questions as $subQuestion) {
                    if ($subQuestion != '')
                        $question->comprehensions()->create([
                            'sub_question' => $subQuestion,
                        ]);
                }
            } else {
                echo "Invalid question type detected";
            }

            // commit if all ok
            DB::commit();
            return redirect()->route('operator.chapter.questionables.questions.create', [$chapter, $request->questionableType])->with(
                [
                    'success' => 'Successfully added',
                ]
            );
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($chapterId, $questionId)
    {
        //
        $chapter = Chapter::findOrFail($chapterId);
        $question = Question::findOrFail($questionId);
        return view('operator.questions.show', compact('chapter', 'question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($chapterId, $questionId)
    {
        //
        $chapter = Chapter::findOrFail($chapterId);
        $question = Question::findOrFail($questionId);
        $types = Type::all();
        return view('operator.questions.edit', compact('chapter', 'question', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $chapterId, $questionId)
    {
        //
        $request->validate([
            'statement' => 'required',
            'exercise_no' => 'nullable|numeric',
            'frequency' => 'required|numeric',
            'is_conceptual' => 'required|boolean',
        ]);

        $question = Question::findOrFail($questionId);

        DB::beginTransaction();

        try {
            $question->update([
                'statement' => $request->statement,
                'exercise_no' => $request->exercise_no,
                'is_conceptual' => $request->is_conceptual,
                'frequency' => $request->frequency,
            ]);

            // mcqs
            if ($question->type_id == 1) {
                $correct = '';
                if ($request->check_a) $correct = 'a';
                if ($request->check_b) $correct = 'b';
                if ($request->check_c) $correct = 'c';
                if ($request->check_d) $correct = 'd';

                $question->mcq()->update([
                    'choice_a' => $request->choice_a,
                    'choice_b' => $request->choice_b,
                    'choice_c' => $request->choice_c,
                    'choice_d' => $request->choice_d,
                    'correct' => $correct,
                ]);
            }

            // paraphrasing
            // if ($question->subtype->tagname == 'paraphrasing') {
            //     foreach ($request->poetry_lines as $poetry_line) {
            //         if ($poetry_line != '')
            //             $question->paraphrasings()->update([
            //                 'poetry_line' => $poetry_line,
            //             ]);
            //     }
            // }

            // //comprehension
            // if ($question->subtype->tagname == 'comprehension') {
            //     foreach ($request->sub_questions as $subQuestion) {
            //         if ($subQuestion != '')
            //             $question->comprehensions()->update([
            //                 'sub_question' => $subQuestion,
            //             ]);
            //     }
            // }

            // commit if all ok
            DB::commit();
            return redirect()->route('operator.chapter.questions.index', $chapterId)->with(
                [
                    'success' => 'Successfully updated',
                ]
            );
            // return redirect()->route('admin.chapter.questions.index', [$bookId, $chapterId])->with('success', 'Successfully added');;
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($chapterId, $questionId)
    {
        //
        try {
            $question = Question::findOrFail($questionId);
            $question->delete();
            return redirect()->back()->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
