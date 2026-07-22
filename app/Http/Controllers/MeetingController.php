<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MeetingController extends Controller
{

    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $meetings = Meeting::with('parent', 'student', 'teacher')->latest()->get();
        } else {
            $meetings = Meeting::where('parent_id', Auth::id())
                ->orWhere('student_id', Auth::id())
                ->orWhere('teacher_id', Auth::id())
                ->with('parent', 'student', 'teacher')
                ->latest()
                ->get();
        }

        return view('meetings.index', compact('meetings'));
    }

    public function create()
    {
        $parents = User::where('role', 'parent')->get();
        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();
        return view('meetings.create', compact('parents', 'students', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start' => 'required',
            'end' => 'required',
        ]);

        Meeting::create([
            'uuid' => Str::uuid(),
            'date' => $request->date,
            'start' => $request->start,
            'end' => $request->end,
            'teacher_id' => Auth::user()->id,
            'status' => 'available',
        ]);

        return response()->json('Meeting is saved');;
    }

    public function show(Meeting $meeting)
    {
        if (Auth::user()->role !== 'admin' && !in_array(Auth::id(), [$meeting->parent_id, $meeting->student_id, $meeting->teacher_id])) {
            abort(403);
        }

        return view('meetings.show', compact('meeting'));
    }

    public function edit(Meeting $meeting)
    {
        $parents = User::where('role', 'parent')->get();
        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();
        return view('meetings.edit', compact('meeting', 'parents', 'students', 'teachers'));
    }

    public function update(Request $request, Meeting $meeting)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'lesson_plan' => 'required|string',
            'term' => 'required|string',
            'parent_id' => 'required|exists:users,id',
            'student_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
        ]);

        // Ensure the user is still involved
        if (!in_array(Auth::id(), [$request->parent_id, $request->student_id, $request->teacher_id])) {
            abort(403, 'You must remain involved in the meeting.');
        }

        $meeting->update($request->only(['date', 'time', 'lesson_plan', 'term', 'parent_id', 'student_id', 'teacher_id']));

        return redirect()->route('meetings.index')->with('success', 'Meeting updated successfully.');
    }

    public function destroy(Meeting $meeting)
    {
        $meeting->delete();

        return redirect()->route('meetings.index')->with('success', 'Meeting deleted successfully.');
    }

    public function byDate($date){
        $meetings = Meeting::where('teacher_id', Auth::id())->whereDate('date', Carbon::parse($date))->get();

        return response()->json($meetings);
    }
}
