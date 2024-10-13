<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use App\Models\PaperQuestion;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class PaperQuestionController extends Controller
{
    /**
     * Remove the specified resource from storage.
     */

    public function create($id)
    {
        $paper = Paper::findOrFail($id);
        // get distinct question types from selected chapters
        $questionTypeIds = DB::table('questions')
            ->select('type_id')
            ->distinct()
            ->whereIn('chapter_id', $paper->chapterIdsArray())
            ->pluck('type_id');

        $questionTypes = Type::whereIn('id', $questionTypeIds)->get();
        return view('user.paper-questions.create', compact('paper', 'questionTypes'));
    }

    public function destroy(string $paperId, $paperQuestionId)
    {
        //
        try {
            $paperQuestion = PaperQuestion::findOrFail($paperQuestionId);
            $paperQuestion->delete();
            return redirect()->back()->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
