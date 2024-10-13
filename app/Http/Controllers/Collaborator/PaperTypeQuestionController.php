<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Paper;
use App\Models\Type;
use Illuminate\Http\Request;

class PaperTypeQuestionController extends Controller
{
    //
    public function  create($paperId, $typeId)
    {
        $paper = Paper::findOrFail($paperId);
        $book = $paper->book;
        $type = Type::findOrFail($typeId);

        // $selectedChapters = Chapter::whereIn('id', session('chapterIdsArray'))->get();
        $selectedChapters = Chapter::whereIn('id', session('chapterIdsArray'))
            ->whereHas('questions', function ($query) use ($typeId) {
                return $query->where('type_id', $typeId);
            })->get();


        return view('collaborator.paper-questions.create', compact('paper', 'type', 'selectedChapters'));
    }
}
