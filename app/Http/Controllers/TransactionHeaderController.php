<?php

namespace App\Http\Controllers;

use App\Models\TransactionHeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionHeaderController extends Controller
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
            $transactions = TransactionHeader::with('parent', 'teacher')->latest()->get();
        } else {
            $transactions = TransactionHeader::where('parent_id', Auth::id())
                ->orWhere('teacher_id', Auth::id())
                ->latest()->get();
        }

        return view('transaction_headers.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transaction_headers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice' => 'required|string|unique:transaction_headers',
            'date' => 'required|date',
            'total' => 'required|numeric|min:0',
            'parent_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
        ]);

        TransactionHeader::create([
            'invoice' => $request->invoice,
            'date' => $request->date,
            'total' => $request->total,
            'parent_id' => $request->parent_id,
            'teacher_id' => $request->teacher_id,
        ]);

        return redirect()->route('transaction-headers.index')->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TransactionHeader $transactionHeader)
    {
        if (Auth::user()->role !== 'admin' && $transactionHeader->parent_id !== Auth::id() && $transactionHeader->teacher_id !== Auth::id()) {
            abort(403);
        }

        return view('transaction_headers.show', compact('transactionHeader'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionHeader $transactionHeader)
    {
        return view('transaction_headers.edit', compact('transactionHeader'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransactionHeader $transactionHeader)
    {
        $request->validate([
            'invoice' => 'required|string|unique:transaction_headers,invoice,' . $transactionHeader->id,
            'date' => 'required|date',
            'total' => 'required|numeric|min:0',
            'parent_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
        ]);

        // Ensure the user is either the parent or teacher
        if (Auth::id() != $request->parent_id && Auth::id() != $request->teacher_id) {
            abort(403, 'You must be the parent or teacher for this transaction.');
        }

        $transactionHeader->update($request->only(['invoice', 'date', 'total', 'parent_id', 'teacher_id']));

        return redirect()->route('transaction-headers.index')->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionHeader $transactionHeader)
    {
        $transactionHeader->delete();

        return redirect()->route('transaction-headers.index')->with('success', 'Transaction deleted successfully.');
    }

    public function admin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin only.');
        }

        $transactions = TransactionHeader::with('parent', 'teacher')->latest()->get();
        return view('transaction_headers.admin', compact('transactions'));
    }
}
