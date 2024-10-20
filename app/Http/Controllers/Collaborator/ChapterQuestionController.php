<?php

namespace App\Http\Controllers\Collaborator;

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
    public function index($id)
    {
        //
        $chapter = Chapter::findOrFail($id);
        return view('collaborator.questions.index', compact('chapter'));
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
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $chapterId, $id)
    {
        //
        $chapter = Chapter::findOrFail($chapterId);
        $question = Question::findOrFail($id);
        $types = Type::all();
        return view('collaborator.questions.edit', compact('chapter', 'question', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $chapterId,  string $questionId)
    {
        //
        $request->validate([
            'type_id' => 'required|numeric',
            'statement' => 'required',
            'frequency' => 'required|numeric',
            'is_conceptual' => 'required|boolean',
        ]);

        $question = Question::findOrFail($questionId);

        DB::beginTransaction();
        $bonus = $question->approver_id ? 0 : 20;
        try {
            $question->update([
                'type_id' => $request->type_id,
                'statement' => $request->statement,
                'is_conceptual' => $request->is_conceptual,
                'frequency' => $request->frequency,
                'approver_id' => Auth::user()->id,
                'approved_at' => now()->format('Y-m-d'),
            ]);

            // mcqs
            if (in_array($question->type_id, [1, 23])) {
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

            // poetry lines
            if (in_array($question->type_id, [11, 25])) {

                $question->poetryLines->first()->update([
                    'line_a' => $request->line_a,
                    'line_b' => $request->line_b,
                ]);
            }

            //comprehension
            if (in_array($question->type_id, [19, 29])) {
                $i = 0;

                foreach ($request->sub_questions as $subQuestion) {

                    $question->comprehensions()->find($request->sub_question_ids[$i++])->update([
                        'sub_question' => $subQuestion,
                    ]);
                }
            }
            // give coins
            Auth::user()->sales()->create([
                'coins' => $bonus,
                'price' => 0,
                'remarks' => 'Question approval',
                'expiry_at' => now()->addDays(365),
                'is_verified' => true,
            ]);
            // commit if all ok
            DB::commit();
            return redirect()->route('collaborator.chapter.questions.index', $chapterId)->with(
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
    }
}
