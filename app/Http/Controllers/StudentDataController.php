<?php

namespace App\Http\Controllers;

use App\Models\StudentData;
use App\Models\User;
use Illuminate\Http\Request;

class StudentDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = User::where('role', 'student')->get();
        $setting = Controller::getVerse();
        return view('studentData.index', compact('setting', 'students'));
    }

    /**
     * Display the specified resource.
     */
    public function show(user $student)
    {
        $studentData = StudentData::where('student_id', $student->id)->get();
        $setting = Controller::getVerse();
        return view('studentData.form', compact('studentData', 'setting', 'student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $student)
    {
        $studentData = StudentData::where('student_id', $student->id)->first();
        $setting = Controller::getVerse();
        return view('studentData.form', compact('studentData', 'setting', 'student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $student)
    {
        $data = $request->validate(['profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',]);

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')
                ->store('profile-pictures', 'public');
        }
        $data = [
            'preferred_language' => $request->preferred_language,
            'notes' => $request->notes,
        ];

        if (isset($path)) {
            $student->update(['profile_path' => $path]);
        }

        StudentData::updateOrCreate(
            ['student_id' => $student->id],
            $data
        );

        return redirect()->route('student.index')->with('success', "User {$student->name}'s data has been updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $student)
    {
        $studentData = StudentData::where('student_id', $student->id)->first()->delete();

        return redirect()->route('student.index')->with('success', "User {$student->name}'s data has been deleted");
    }
}
