<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use App\Models\TransactionHeader;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionDetailController extends Controller
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

    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $details = TransactionDetail::with('transactionHeader')->latest()->get();
        } else {
            $details = TransactionDetail::whereHas('transactionHeader', function ($query) {
                $query->where('parent_id', Auth::id())->orWhere('teacher_id', Auth::id());
            })->with('transactionHeader')->latest()->get();
        }

        return view('transaction_details.index', compact('details'));
    }

    public function create(Request $request)
    {
        $headers = TransactionHeader::with('parent', 'teacher')->get();
        $reports = Report::with('parent', 'student', 'teacher')->get();
        $selectedHeader = $request->header_id ? TransactionHeader::find($request->header_id) : null;
        return view('transaction_details.create', compact('headers', 'reports', 'selectedHeader'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_header_id' => 'required|exists:transaction_headers,id',
            'report_id' => 'required|exists:reports,id',
            'price_per_hour' => 'required|numeric|min:0',
            'hours' => 'required|integer|min:1',
            'detail' => 'required|string',
        ]);


        $subtotal = $request->price_per_hour * $request->hours;

        TransactionDetail::create([
            'transaction_header_id' => $request->transaction_header_id,
            'report_id' => $request->report_id,
            'price_per_hour' => $request->price_per_hour,
            'hours' => $request->hours,
            'subtotal' => $subtotal,
            'detail' => $request->detail,
        ]);

        return redirect()->route('transaction-details.index')->with('success', 'Detail added successfully.');
    }

    public function show(TransactionDetail $transactionDetail)
    {
        if (Auth::user()->role !== 'admin' && $transactionDetail->transactionHeader->parent_id !== Auth::id() && $transactionDetail->transactionHeader->teacher_id !== Auth::id()) {
            abort(403);
        }

        return view('transaction_details.show', compact('transactionDetail'));
    }

    public function edit(TransactionDetail $transactionDetail)
    {
        $headers = TransactionHeader::where('parent_id', Auth::id())
            ->orWhere('teacher_id', Auth::id())
            ->get();
        $reports = Report::where('teacher_id', Auth::id())
            ->orWhere('parent_id', Auth::id())
            ->orWhere('student_id', Auth::id())
            ->get();
        return view('transaction_details.edit', compact('transactionDetail', 'headers', 'reports'));
    }

    public function update(Request $request, TransactionDetail $transactionDetail)
    {
        $request->validate([
            'transaction_header_id' => 'required|exists:transaction_headers,id',
            'report_id' => 'required|exists:reports,id',
            'price_per_hour' => 'required|numeric|min:0',
            'hours' => 'required|integer|min:1',
            'detail' => 'required|string',
        ]);

        // Check if new header belongs to user (as parent or teacher)
        $header = TransactionHeader::where('id', $request->transaction_header_id)
            ->where(function ($query) {
                $query->where('parent_id', Auth::id())->orWhere('teacher_id', Auth::id());
            })->first();
        if (!$header) {
            abort(403);
        }

        // Check if report involves the user
        $report = Report::where('id', $request->report_id)
            ->where(function ($query) {
                $query->where('teacher_id', Auth::id())
                      ->orWhere('parent_id', Auth::id())
                      ->orWhere('student_id', Auth::id());
            })->first();
        if (!$report) {
            abort(403);
        }

        $subtotal = $request->price_per_hour * $request->hours;

        $transactionDetail->update([
            'transaction_header_id' => $request->transaction_header_id,
            'report_id' => $request->report_id,
            'price_per_hour' => $request->price_per_hour,
            'hours' => $request->hours,
            'subtotal' => $subtotal,
            'detail' => $request->detail,
        ]);

        return redirect()->route('transaction-details.index')->with('success', 'Detail updated successfully.');
    }

    public function destroy(TransactionDetail $transactionDetail)
    {
        $transactionDetail->delete();

        return redirect()->route('transaction-details.index')->with('success', 'Detail deleted successfully.');
    }
}
