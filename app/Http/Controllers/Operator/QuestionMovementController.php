<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;

class QuestionMovementController extends Controller
{
    public function index($id)
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
        $chapter = Chapter::findOrFail($id);
        return view('operator.questions.move', compact('chapter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $chapterId)
    {
        //
        $request->validate([
            'question_ids_array' => 'required',
            'chapter_id_to_move' => 'required|numeric',
        ]);

        try {
            $chapter = Chapter::findOrFail($chapterId);

            $questionIdsArray = array();
            $questionIdsArray = $request->question_ids_array;
            $data = [
                'chapter_id' => $request->chapter_id_to_move,
            ];
            Question::whereIn('id', $questionIdsArray)->update($data);
            return redirect()->route('operator.question-movements.edit', $chapter);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
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
