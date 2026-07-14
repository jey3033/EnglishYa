<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $courses = Course::all();
        $setting = Controller::getVerse();
        return view('course.index', compact('courses', 'setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setting = Controller::getVerse();
        return view('course.form', compact('setting'));
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

        $course = Course::create([
            'uuid' => Str::uuid(),
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        return redirect()->route('course.index')->with('success', "Course {$course->name} created.");

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $setting = Controller::getVerse();
        return view('course.form', compact('course', 'setting'));
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

        $course->update($data);

        return redirect()->route('course.index')->with('success', "Course {$course->name} updated.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()
            ->route('course.index')
            ->with('success', "Course deleted successfully.");
    }
}
