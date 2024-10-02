<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Paper;
use Illuminate\Http\Request;

class QuestionChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        $paper = Paper::find($id);
        return view('user.question-choices.index', compact('paper'));
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
    public function show($id, $choice)
    {
        //
        if (session('chapterIdsArray')) {
            $paper = Paper::find($id);
            //send only those chapters which have MCQs 
            $chapters = Chapter::whereIn('id', session('chapterIdsArray'))->get();






            //     if ($choice == 1)  return view('user.paper-questions.mcqs.create', compact('paper', 'chapters'));
            //     elseif ($choice == 2) //shorts
            //         return view('user.paper-questions.shorts.create', compact('paper', 'chapters'));
            //     elseif ($choice == 3) //simple long with title + statement
            //         return view('user.paper-questions.longs.simple.title-statement', compact('paper', 'chapters'));
            //     elseif ($choice == 4) //simple long- statement only
            //         return view('user.paper-questions.longs.simple.statement-only', compact('paper', 'chapters'));
            //     elseif ($choice == 5) //partial long- notitle, orchoice
            //         return view('user.paper-questions.longs.partial.optional-or', compact('paper', 'chapters'));
            //     elseif ($choice == 6) //simple long- statement only
            //         return view('user.paper-questions.longs.partial.mendatory', compact('paper', 'chapters'));
            //     elseif ($choice == 7) //simple long- statement only
            //         return view('user.paper-questions.longs.partial.vertical', compact('paper', 'chapters'));
            //     elseif ($choice == 8) //simple long- statement only
            //         return view('user.paper-questions.longs.partial.horizontal', compact('paper', 'chapters'));
            //     elseif ($choice == 9) //simple long- statement only
            //         return view('user.paper-questions.longs.paraphrasing', compact('paper', 'chapters'));
            //     elseif ($choice == 10) //simple long- statement only
            //         return view('user.paper-questions.longs.comprehension', compact('paper', 'chapters'));
            // }
            // number of choices will be set to zero for simple question, 
            // non zero for partial question


            $choices = 1;

            if ($choice == 1) { //mcq

                $questionTitle = 'MCQ';
                return view('user.paper-questions.multipart-multichapter', compact('paper', 'chapters', 'questionTitle', 'choice'));
            } elseif ($choice == 2) { //shorts

                $questionTitle = 'Short Q.';
                return view('user.paper-questions.multipart-multichapter', compact('paper', 'chapters', 'questionTitle', 'choice'));
            } elseif ($choice == 3) { //simple long with title + statement

                $questionTitle = 'Long : Title + Statement';
                return view('user.paper-questions.simple-question', compact('paper', 'chapters', 'questionTitle', 'choice'));
            } elseif ($choice == 4) { //long- statement only

                $questionTitle = 'Long: Statement Only';
                return view('user.paper-questions.simple-question', compact('paper', 'chapters', 'questionTitle', 'choice'));
            } elseif ($choice == 5) { //long : partial-or

                $questionTitle = 'Long: Partial-Or';
                return view('user.paper-questions.simple-question', compact('paper', 'chapters', 'questionTitle', 'choice'));
            } elseif ($choice == 6) { //Long: mendatory parts

                $questionTitle = 'Long: Mendatory Parts';
                return view('user.paper-questions.simple-question', compact('paper', 'chapters', 'questionTitle', 'choice'));
            } elseif ($choice == 7) { //Long : partial, vertical

                $questionTitle = 'Long: Vertical Parts';
                return view('user.paper-questions.multipart-singlechapter', compact('paper', 'chapters', 'questionTitle', 'choice'));
            } elseif ($choice == 8) { //Long: partial: horizontal

                $questionTitle = 'Long: Horizontal Parts';
                return view('user.paper-questions.multipart-singlechapter', compact('paper', 'chapters', 'questionTitle', 'choice'));
            } elseif ($choice == 9) { //paraphrasing

                $questionTitle = 'Long: Pararphrasing';
                return view('user.paper-questions.simple-question', compact('paper', 'chapters', 'questionTitle', 'choice'));
            } elseif ($choice == 10) { //comprehension

                $questionTitle = 'Long: Comprehension';
                return view('user.paper-questions.simple-question', compact('paper', 'chapters', 'questionTitle', 'choice'));
            }
        } else {
            echo "Chapters not selected!";
        }
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
}
