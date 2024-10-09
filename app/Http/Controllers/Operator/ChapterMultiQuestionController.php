<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;

class ChapterMultiQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        $types = Type::all();
        $chapter = Chapter::find($id);
        return view('operator.multi-questions.index', compact('chapter', 'types'));
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
    public function update(Request $request, $chapterId, string $id)
    {
        //
        $request->validate([
            'question_ids_array' => 'required',
            'type_id' => 'required|numeric',
        ]);

        try {
            $chapter = Chapter::find($id);
            $type_id = $request->type_id;

            $questionIdsArray = array();
            $questionIdsArray = $request->question_ids_array;

            $data = [
                'type_id' => $type_id,
            ];

            $questions = Question::whereIn('id', $questionIdsArray)->update($data);
            return redirect()->route('operator.chapter.multi-questions.index', $chapter);
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
