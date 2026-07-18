<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\TransactionHeader;
use App\Models\Course;
use App\Models\Term;

class StudentController extends Controller
{
    public function index(){
        $setting = Controller::getVerse();
        return view('student.dashboard', compact('setting'));
    }

    public function enrollindex() {
        $setting = Controller::getVerse();
        $transactions = TransactionHeader::where('student_id', Auth::User()->id)->get();
        return view('student.transaction.index', compact('setting', 'transactions'));
    }

    public function enrollcreate() {
        $setting = Controller::getVerse();
        $courses = Course::all();
        $packages = Term::all();
        return view('student.transaction.form', compact('setting', 'courses', 'packages'));
    }

    public function enrollstore(Request $request) {
        $request->validate([
            'enroll' => ['required', 'array'],
            'enroll.*' => ['required', 'array'],

            'enroll.*.course_id' => ['required', 'exists:courses,id'],
            'enroll.*.package_id' => ['required', 'exists:terms,id'],
        ]);
        DB::transaction(function () use ($request) {
            $transaction = TransactionHeader::create([
                'uuid' => Str::uuid(),
                'invoice' => "Waiting for Admin",
                'date' => Carbon::today(),
                'total' => 0,
                'student_id' => Auth::user()->id,
                'detail' => "",
                'transaction_status' => 'pending'
            ]);
            foreach ($request->enroll as $detail) {
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
        });

        return redirect()->route('student.transaction.index')->with('success', "Enrollment Success!");
    }

    public function scheduleindex() {
        $setting = Controller::getVerse();
        return view('student.schedule.index', compact('setting'));
    }
}
