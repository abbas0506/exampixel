<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Subject;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ProfileController extends Controller
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
        $request->validate([
            'user_id' => 'required',
            'institution' => 'required',
            'phone' => 'nullable|numeric',
            'subject_id' => 'nullable'

        ]);

        try {
            Profile::create($request->all());
            return redirect('user')->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
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
        $user = User::findOrFail($id);
        $subjects = Subject::all();
        return view('user.profiles.edit', compact('user', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'institution' => 'required',
            'phone' => 'nullable|numeric',
            'subject_id' => 'nullable'

        ]);

        $user = User::findOrFail($id);

        try {
            if ($user->profile)
                $user->profile->update($request->all());
            else
                $user->profile()->create($request->all());
            return redirect('user')->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
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
