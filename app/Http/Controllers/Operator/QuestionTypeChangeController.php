<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;

class QuestionTypeChangeController extends Controller
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
        $types = Type::all();
        $chapter = Chapter::findOrFail($id);
        return view('operator.questions.type-change', compact('chapter', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $chapterId)
    {
        //
        $request->validate([
            'question_ids_array' => 'required',
            'type_id' => 'required|numeric',
        ]);

        try {
            $chapter = Chapter::findOrFail($chapterId);
            $type_id = $request->type_id;

            $questionIdsArray = array();
            $questionIdsArray = $request->question_ids_array;

            $data = [
                'type_id' => $type_id,
            ];

            $questions = Question::whereIn('id', $questionIdsArray)->update($data);
            return redirect()->route('operator.type-changes.edit', $chapter);
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
