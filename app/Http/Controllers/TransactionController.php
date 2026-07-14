<?php

namespace App\Http\Controllers;

use App\Models\TransactionHeader;
use App\Models\User;
use App\Models\Term;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()?->role !== 'admin') {
                abort(403, 'Access denied. Admin only.');
            }
            return $next($request);
        })->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $transactions = TransactionHeader::latest()->get();
        } else {
            $transactions = TransactionHeader::where('parent_id', Auth::id())
                ->orWhere('teacher_id', Auth::id())
                ->latest()->get();
        }

        $setting = Controller::getVerse();
        return view('admin.transaction.index', compact('transactions', 'setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setting = Controller::getVerse();
        $students = User::where('role','student')->get();
        $courses = Course::all();
        $terms = Term::all();
        return view('admin.transaction.form', compact('setting', 'students', 'courses', 'terms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice' => ['required','string', Rule::unique('transaction_headers')->ignore($transaction->id)],
            'date' => 'required|date',
            'student_id' => 'required|exists:users,id',

            'details' => 'required|array|min:1',

            'details.*.course_id' => 'required|exists:courses,id',
            'details.*.term_id' => 'required|exists:terms,id',
            'details.*.price_per_hour' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $transaction = TransactionHeader::create([
                'uuid' => Str::uuid(),
                'invoice' => $request->invoice,
                'date' => $request->date,
                'total' => 0,
                'student_id' => $request->student_id,
                // 'teacher_id' => $request->teacher_id,
                'detail' => $request->detail ?? "",
                'transaction_status' => 'pending'
            ]);

            $total = 0;
            foreach ($request->details as $detail) {
                $term = Term::findOrFail($detail['term_id']);
                $subtotal = $detail['price_per_hour'] * $term->meeting_number;
                $total += $subtotal;

                $transaction->details()->create([
                    'course_id' => $detail['course_id'],
                    'term_id' => $detail['term_id'],
                    'price_per_hour' => $detail['price_per_hour'],
                    'hours' => $term->meeting_number,
                    'subtotal' => $subtotal,
                    'enrollment_status' => 'pending'
                ]);                
            }

            $transaction->total = $total;

            $transaction->save();
        });

        return redirect()->route('transaction.index')->with('success', 'Transaction created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionHeader $transaction)
    {
        $setting = Controller::getVerse();
        $students = User::where('role','student')->get();
        $courses = Course::all();
        $terms = Term::all();
        return view('admin.transaction.form', compact('setting', 'students', 'courses', 'terms', 'transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransactionHeader $transaction)
    {
        $request->validate([
            'invoice' => ['required','string', Rule::unique('transaction_headers')->ignore($transaction->id)],
            'date' => 'required|date',
            'student_id' => 'required|exists:users,id',

            'details' => 'required|array|min:1',

            'details.*.course_id' => 'required|exists:courses,id',
            'details.*.term_id' => 'required|exists:terms,id',
            'details.*.price_per_hour' => 'required|numeric|min:0',
        ]);
        DB::transaction(function () use ($request, $transaction) {
            $transaction->update([
                'invoice' => $request->invoice,
                'date' => $request->date,
                'student_id' => $request->student_id,
                'detail' => $request->detail,
                'transaction_status' => $request->transaction_status
            ]);

            $transaction->details()->delete();
            $total = 0;
            foreach ($request->details as $detail) {
                $term = Term::findOrFail($detail['term_id']);
                $subtotal = $detail['price_per_hour'] * $term->meeting_number;
                $total += $subtotal;

                $transaction->details()->create([
                    'course_id' => $detail['course_id'],
                    'term_id' => $detail['term_id'],
                    'price_per_hour' => $detail['price_per_hour'],
                    'hours' => $detail['hours'] ?? 1,
                    'subtotal' => $subtotal,
                ]);
            }

            $transaction->update(['total' => $total]);
        });

        return redirect()->route('transaction.index')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionHeader $transaction)
    {
        $transaction->details()->delete();
        $transaction->delete();

        return redirect()->route('transaction.index')->with('success', 'Transaction deleted successfully.');
    }
}
