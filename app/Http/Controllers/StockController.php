<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use Auth;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::where('owner', auth()->user()->email)->get();
        return view('stocks.index', compact('stocks'));
    }
 

    public function store(Request $request)
{
    $request->validate([
        'item_name' => 'required|string|max:255',
        'buying_price' => 'required|numeric|min:0',
        'selling_price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',  
    ]);
    $user = Auth::user();


    // Calculate profit per item
    $profit_per_item = $request->selling_price - $request->buying_price;

     $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('stock_images', 'public');
    }

     $stock = new Stock([
        'owner' => $user->email,
        'item_name' => $request->item_name,
        'buying_price' => $request->buying_price,
        'selling_price' => $request->selling_price,
        'quantity' => $request->quantity,
        'profit_per_item' => $profit_per_item,
        'image' => $imagePath,  
    ]);

     $stock->save();

     return redirect()->route('stocks.index')->with('success', 'Stock item added successfully!');
}

 
    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        return response()->json($stock);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'buying_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        $stock = Stock::findOrFail($id);
        $stock->item_name = $request->item_name;
        $stock->buying_price = $request->buying_price;
        $stock->selling_price = $request->selling_price;
        $stock->quantity = $request->quantity;
        $stock->profit_per_item = $request->selling_price - $request->buying_price;
        $stock->save();

        return redirect()->route('stocks.index')->with('success', 'Stock item updated successfully!');
    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->route('stocks.index')->with('success', 'Stock item deleted successfully!');
    }
}
