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
        $Term = Term::all();
        return view('term-master', compact('term'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('term-form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  =>  'required|string'
        ]);

        $new = Term::create([
            'name' => $data['name']
        ]);

        return redirect()->intended('terms')->with('success', "Term {{$data['name']}} created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(term $term)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(term $term)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, term $term)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(term $term)
    {
        //
    }
}
