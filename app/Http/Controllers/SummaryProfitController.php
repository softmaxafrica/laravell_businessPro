<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SummaryProfitController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Retrieve authenticated user
        
        $dailySummaries = DB::table('summary_profits')
            ->select('date', 'total_sales', 'total_expenses', 'total_profit', 'net_day_profit', 'deviation')
            ->where('user_email', $user->email)
            ->orderBy('date', 'desc')
            ->get();

        return view('summary.index', compact('dailySummaries'));
    }
}
