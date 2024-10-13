<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Exception;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $grades = Grade::all();
        return view('admin.grades.index', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $grades = Grade::all();
        return view('admin.grades.create', compact('grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
        ]);

        try {
            Grade::create($request->all());
            return redirect()->route('admin.grades.index')->with('success', 'Successfully added');;
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
        $grade = Grade::findOrFail($id);
        return view('admin.grades.show', compact('grade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $grade = Grade::findOrFail($id);
        return view('admin.grades.edit', compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required',
        ]);

        try {
            $grade = Grade::findOrFail($id);
            $grade->update($request->all());
            return redirect()->route('admin.grades.index')->with('success', 'Successfully updated!');;
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
        $grade = Grade::findOrFail($id);
        try {
            $grade = Grade::findOrFail($id);
            $grade->delete();
            return redirect()->back()->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
