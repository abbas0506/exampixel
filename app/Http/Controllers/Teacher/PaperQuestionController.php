<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\PaperQuestion;
use Exception;
use Illuminate\Http\Request;

class PaperQuestionController extends Controller
{
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $paperId, $paperQuestionId)
    {
        //
        try {
            $paperQuestion = PaperQuestion::find($paperQuestionId);
            $paperQuestion->delete();
            return redirect()->back()->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
