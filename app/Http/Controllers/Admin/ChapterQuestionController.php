<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
    public function index($chapterId)
    {
        //
        $chapter = Chapter::find($chapterId);
        $book = $chapter->book;
        $questions = $chapter->questions;
        return view('admin.qbank.questions.index', compact('book', 'chapter', 'questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($chapterId)
    {
        //
        $chapter = Chapter::find($chapterId);
        $questions = $chapter->questions;
        $book = $chapter->book;

        $types = Type::all();
        return view('admin.qbank.questions.create', compact('book', 'chapter', 'questions', 'types'));
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
            'type_id' => 'required',
        ]);

        $chapter = Chapter::find($chapterId);
        $book = $chapter->book;

        DB::beginTransaction();

        try {

            $question = $chapter->questions()->create([
                'user_id' => Auth::user()->id,
                'book_id' => $chapter->book_id,
                'type_id' => $request->type_id,
                'marks' => $request->marks,

                'statement' => $request->statement,
                'exercise_no' => $request->exercise_no,
                'is_conceptual' => $request->is_conceptual,
                'frequency' => $request->frequency,
            ]);

            // mcqs
            if ($subtype->tagname == 'mcq') {
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
            }

            // paraphrasing
            if ($subtype->tagname == 'paraphrasing') {
                foreach ($request->poetry_lines as $poetry_line) {
                    if ($poetry_line != '')
                        $question->paraphrasings()->create([
                            'poetry_line' => $poetry_line,
                        ]);
                }
            }

            //comprehension
            if ($subtype->tagname == 'comprehension') {
                foreach ($request->sub_questions as $subQuestion) {
                    if ($subQuestion != '')
                        $question->comprehensions()->create([
                            'sub_question' => $subQuestion,
                        ]);
                }
            }

            // commit if all ok
            DB::commit();
            return redirect()->back()->with(
                [
                    'type_id' => $request->type_id,
                    'subtype_id' => $request->subtype_id,
                    'marks' => $request->marks,
                    'exercise_no' => $request->exercise_no,
                    'frequency' => $request->frequency,
                    'is_conceptual' => $request->is_conceptual,
                    'subtypes' => $book->subtypes($request->type_id),
                    'success' => 'Successfully added',
                ]
            );
            // return redirect()->route('admin.chapter.questions.index', [$bookId, $chapterId])->with('success', 'Successfully added');;
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
        $chapter = Chapter::find($chapterId);
        $book = $chapter->book;
        $question = Question::find($questionId);
        return view('admin.qbank.questions.show', compact('book', 'chapter', 'question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($chapterId, $questionId)
    {
        //
        $chapter = Chapter::find($chapterId);
        $book = $chapter->book;
        $question = Question::find($questionId);
        return view('admin.qbank.questions.edit', compact('book', 'chapter', 'question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $chapterId, $questionId)
    {
        //
        $request->validate([
            'sr' => 'required|numeric',
            'exercise_no' => 'nullable|numeric',
            'statement' => 'required',
            'marks' => 'required|numeric',
            'frequency' => 'required|numeric',
            'is_conceptual' => 'required|boolean',
        ]);

        $question = Question::find($questionId);

        DB::beginTransaction();

        try {
            $question->update([
                'marks' => $request->marks,
                'statement' => $request->statement,
                'exercise_no' => $request->exercise_no,
                'is_conceptual' => $request->is_conceptual,
                'frequency' => $request->frequency,
            ]);

            // mcqs
            if ($question->type->name == 'Objective') {
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
            return redirect()->route('admin.chapter.questions.index', $question->chapter)->with(
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
            $question = Question::find($questionId);
            $question->delete();
            return redirect()->back()->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
