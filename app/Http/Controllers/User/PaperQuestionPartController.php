<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PaperQuestionPart;
use App\Models\Question;
use Exception;
use Illuminate\Http\Request;

class PaperQuestionPartController extends Controller
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
    public function refresh($paperQuestionPartId)
    {
        $paperQuestionPart = PaperQuestionPart::findOrFail($paperQuestionPartId);

        $alreadyIncludedQuestionIds = $paperQuestionPart->paperQuestion->paper->paperQuestionParts->pluck('question_id');

        $replacingQuestion = Question::where('chapter_id', $paperQuestionPart->question->chapter_id)
            ->where('type_id', $paperQuestionPart->question->type_id)
            ->whereNotIn('id', $alreadyIncludedQuestionIds)
            ->get()
            ->random(1)
            ->first();

        try {
            $paperQuestionPart->update([
                'question_id' => $replacingQuestion->id,
            ]);
            return redirect()->back();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
