<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Question;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $books = Book::where('subject_id', Auth::user()->teacher->subject_id)->get();
        $activeBook = $books->first();
        $activeChapter = $activeBook->chapters->first();
        return view('collaborator.approvables.index', compact('books', 'activeBook', 'activeChapter'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $question = Question::find($id);
        $similarQuestions = $question->similarQuestions();
        return view('collaborator.approvables.show', compact('question', 'similarQuestions'));
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
    public function update(Request $request, string $questionId)
    {
        //
        $request->validate([
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
                'approver_id' => Auth::user()->id,
                'approved_at' => now()->format('Y-m-d'),
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

            if ($request->splitted_statement != '') {
                Question::create([
                    'user_id' => Auth::user()->id,
                    'chapter_id' => $question->chapter_id,
                    'type_id' => $question->type_id,
                    'subtype_id' => $question->subtype_id,
                    'exercise_no' => $question->exercise_no,
                    'statement' => $request->splitted_statement,
                    'marks' => $question->marks,
                    'frequency' => $question->frequency,
                    'is_conceptual' => $question->is_conceptual,
                ]);
            }


            Auth::user()->sales()->create([
                'coins' => 20,
                'price' => 0,
                'remarks' => 'Question approval',
                'expiry_at' => now()->addDays(365),
                'is_verified' => true,
            ]);
            // commit if all ok
            DB::commit();
            return redirect('/')->with(
                [
                    'success' => 'Successfully updated',
                ]
            );
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $question = Question::find($id);
            $question->delete();
            return redirect('/')->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
