<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class BusinessController extends Controller
{
    public function index()
    {
        $business = Business::where('owner', auth()->user()->email)->first();
        return view('business.index', compact('business'));    
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'expected_profit' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $business_period_days = $start_date->diffInDays($end_date) + 1; // Include the start and end dates

        $user = Auth::user();

        $business = new Business([
            'owner' => $user->email,
            'name' => $request->name,
            'business_period_days' => $business_period_days,
            'expected_profit' => $request->expected_profit,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        $business->save();

        return redirect()->route('business.index')->with('success', 'Business details added successfully!');
    }
}
