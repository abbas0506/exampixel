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
        $chapter = Chapter::findOrFail($chapterId);
        return view('admin.qbank.questions.index', compact('chapter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($chapterId)
    {
        //get types excluding: stanza and اشعار کی تشریح
        $types = Type::whereNotIn('id', [11, 25])->get();
        $chapter = Chapter::findOrFail($chapterId);

        return view('admin.qbank.questions.create', compact('chapter', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $chapterId)
    {
        //
        $request->validate([
            'type_id' => 'required|numeric',
            'statement' => 'required',
            'frequency' => 'required|numeric',
        ]);

        $chapter = Chapter::findOrFail($chapterId);
        DB::beginTransaction();

        try {
            $question = $chapter->questions()->create([
                'user_id' => Auth::user()->id,
                'type_id' => $request->type_id,
                'statement' => $request->statement,
                'frequency' => $request->frequency,
                'is_conceptual' => 0,
            ]);

            // mcqs or معروضی
            if ($request->type_id == 1 || $request->type_id == 23) {
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
            } elseif ($request->type_id == 19 || $request->type_id == 29) {
                //comprehension or عبارت سے سوالات
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

            return redirect()->route('admin.chapter.questions.create', [$chapter])->with(
                [
                    'type_id' => $request->type_id,
                    'success' => 'Successfully added',
                ]
            );
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->withErrors($ex->getMessage());
        }
        // echo 'Chapter question';
    }

    /**
     * Display the specified resource.
     */
    public function show($chapterId, $questionId)
    {
        //
        $chapter = Chapter::findOrFail($chapterId);
        $question = Question::findOrFail($questionId);
        return view('admin.qbank.questions.show', compact('chapter', 'question'));
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
        return view('admin.qbank.questions.edit', compact('chapter', 'question', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $chapterId, $questionId)
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

        try {
            $question->update([
                'type_id' => $request->type_id,
                'statement' => $request->statement,
                'is_conceptual' => $request->is_conceptual,
                'frequency' => $request->frequency,
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

            // commit if all ok
            DB::commit();
            return redirect()->route('admin.chapter.questions.index', $chapterId)->with(
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
