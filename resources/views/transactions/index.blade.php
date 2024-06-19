@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Transactions</h1>
    <h2>Sales Transactions</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Sale Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->date_of_transaction }}</td>
                <td>{{ $sale->owner }}</td>
                <td>{{ $sale->item_name }}</td>
                <td>{{ $sale->quantity }}</td>
                <td>{{ $sale->sale_price }}</td>
                <td>{{ $sale->total_price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
