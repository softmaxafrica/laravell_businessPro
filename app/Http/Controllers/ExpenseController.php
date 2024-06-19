<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $expenses = Expense::where('user_email', $user->email)->orderBy('date_of_transaction', 'desc')->get();
        return view('expenses.index', compact('expenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_of_transaction' => 'required|date',
            'amount_used' => 'required|numeric|min:0',
            'reason_for_expense' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        
        $expense = Expense::create([
            'user_email' => $user->email,
            'date_of_transaction' => $request->date_of_transaction,
            'amount_used' => $request->amount_used,
            'reason_for_expense' => $request->reason_for_expense,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }
}
