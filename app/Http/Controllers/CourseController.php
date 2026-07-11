<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $Data = Course::all();
        return view('course-master', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course-form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  =>  'required|string',
            'description'  =>  'required|string'
        ]);

        $new = Course::create([
            'name' => $data['name'],
            'description' => $data['description']
        ]);

        return redirect()->intended('course')->with('success', "Course {{$data['name']}} Created Successfully");

    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $data = Course::where('id',$course->id)->first();

        return view('course-detail', compact($data));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $data = Course::where('id',$course->id)->first();

        return view('course-form', compact($data));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'name'  =>  'required|string',
            'description'  =>  'required|string'
        ]);

        $new = Course::where('id', $course->id)->first();
        $new->name = $data['name'];
        $new->description = $data['description'];

        return redirect()->intended('course')->with('success', "Course {{$data['name']}} Created Successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $data = Course::where('id', $course->id)->first();
        $data->delete();
    }
}
