<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $terms = Term::all();
        $setting = Controller::getVerse();
        return view('term.index', compact('terms', 'setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setting = Controller::getVerse();
        return view('term.form', compact('setting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  =>  'required|string'
        ]);

        $new = Term::create($data);

        return redirect()->route('term.index')->with('success', "Term {$new->name} created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Term $term)
    {
        $setting = Controller::getVerse();
        return view('term.detail', compact('term', 'setting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Term $term)
    {
        $setting = Controller::getVerse();
        return view('term.form', compact('term', 'setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Term $term)
    {
        $data = $request->validate([
            'name'  =>  'required|string'
        ]);

        $term->update($data);

        return redirect()->route('term.index')->with('success', "Term {$term->name} updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Term $term)
    {
        $term->delete();

        return redirect()
            ->route('term.index')
            ->with('success', "Term deleted successfully.");
    }
}
