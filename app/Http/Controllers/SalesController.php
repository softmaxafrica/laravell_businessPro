<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stocks = Stock::where('owner', $user->email)->get();
        return view('sales.index', compact('stocks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'sale_price' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();

        // Fetch the stock item
        $stock = Stock::where('owner', $user->email)
                      ->where('item_name', $request->item_name)
                      ->first();

        if (!$stock) {
            return redirect()->back()->with('error', 'Stock not found for the item.');
        }

        // Calculate total price of the sale
        $total_price = $request->quantity * $request->sale_price;

        // Calculate total profit based on stock's buying price
        $buyingPrice = $stock->buying_price; // Assuming buying price is fetched from the stock
        $total_profit = ($request->sale_price - $buyingPrice) * $request->quantity;

        // Create a new sale record
        Sale::create([
            'owner' => $user->email,
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
            'sale_price' => $request->sale_price,
            'total_price' => $total_price,
            'total_profit' => $total_profit,
            'buying_price' => $buyingPrice,
            'date_of_transaction' => now(),
        ]);

        // Update stock quantity
        $stock->quantity -= $request->quantity;
        $stock->save();

        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully!');
    }
}
