<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Models\Term;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;

class ParentController extends Controller
{
    public function index() {
        $setting = Controller::getVerse();
        $children = User::where('parent_id', Auth::user()->id)->get();
        return view('parent.dashboard', compact('setting', 'children'));
    }

    // child management section
    public function childindex() {
        $setting = Controller::getVerse();
        $children = User::where('parent_id', Auth::user()->id)->get();
        return view('parent.child.index', compact('setting', 'children'));
    }

    public function childcreate(){
        $setting = Controller::getVerse();

        return view('parent.child.form', compact('setting'));
    }

    public function childstore(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'student',
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'parent_id' => Auth::user()->id,
            'is_active' => false,
        ]);

        return redirect()->route('parent.child.index')->with('success', "Children {$user->name} registered");
    }

    public function childedit(User $child){
        $setting = Controller::getVerse();
        return view('parent.child.form', compact('setting', 'child'));
    }

    public function childupdate(User $child, Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$child->id,
            'phone_number' => 'required'
        ]);

        $child->update($data);

        return redirect()->route('parent.child.index')->with('success', "Children {$child->name}'s data updated");
    }

    public function childdestroy(User $child){
        $child->delete();

        return redirect()->route('parent.child.index')->with('success', 'User deleted.');
    }

    public function childchangepassword(User $child){
        $setting = Controller::getVerse();
        return view('parent.child.changepassword', compact('setting', 'child'));
    }

    public function updatepassword(User $child, Request $request) {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $child->password = Hash::make($request->password);

        $child->save();

        return redirect()->route('parent.child.index')->with('success', "Children {$child->name}'s password updated.");
    }

    // enrollment system
    public function enrollindex() {
        $setting = Controller::getVerse();
        $children = User::where('parent_id', Auth::user()->id)->get();
        return view('parent.enroll.index', compact('setting', 'children'));
    }

    public function enrollcreate(){
        $setting = Controller::getVerse();
        $children =  User::where('parent_id', Auth::user()->id)->get();
        $courses = Course::all();
        $packages = Term::all();

        return view('parent.enroll.form', compact('setting', 'children', 'courses', 'packages'));
    }

    public function enrollstore(Request $request){
        $request->validate([
            'children' => ['required', 'array'],
            'children.*.student_id' => ['required', 'exists:users,id'],

            'enroll' => ['required', 'array'],
            'enroll.*' => ['required', 'array'],

            'enroll.*.*.course_id' => ['required', 'exists:courses,id'],
            'enroll.*.*.package_id' => ['required', 'exists:terms,id'],
        ]);
        DB::transaction(function () use ($request) {
            foreach ($request->children as $childIndex => $child) {
                $transaction = TransactionHeader::create([
                    'uuid' => Str::uuid(),
                    'invoice' => "Waiting for Admin",
                    'date' => Carbon::today(),
                    'total' => 0,
                    'student_id' => $child['student_id'],
                    // 'teacher_id' => $request->teacher_id,
                    'detail' => "",
                    'transaction_status' => 'pending'
                ]);
                foreach ($request->enroll[$childIndex] as $detail) {
                    $term = Term::findOrFail($detail['package_id']);

                    $transaction->details()->create([
                        'course_id' => $detail['course_id'],
                        'term_id' => $detail['package_id'],
                        'price_per_hour' => 0,
                        'hours' => $term->meeting_number,
                        'subtotal' => 0,
                        'enrollment_status' => 'pending'
                    ]);
                }
            }
        });

        return redirect()->route('parent.transaction.index')->with('success', "Enrollment Success!");
    }

    public function scheduleindex(){
        $setting = Controller::getVerse();
        return view('parent.schedule.index', compact('setting'));
    }

    // API Section
    public function students(User $parent){
        return response()->json(
            User::where('parent_id', $parent->id)
                ->where('role', 'student')
                ->orderBy('name')
                ->get(['id', 'name'])
        );
    }
}
