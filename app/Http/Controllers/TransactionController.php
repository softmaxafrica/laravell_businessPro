<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Retrieve authenticated user

        // Fetch sales transactions for the authenticated user
        $sales = Sale::where('owner', $user->email)
                     ->orderBy('date_of_transaction', 'desc')
                     ->get();

        return view('transactions.index', compact('sales'));
    }
}
