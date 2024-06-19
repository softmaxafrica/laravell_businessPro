@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Stock Management</h1>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addStockModal">Add Item</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Buying Price</th>
                <th>Selling Price</th>
                <th>Quantity</th>
                <th>Profit Per Item</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
            <tr>
                <td>{{ $stock->item_name }}</td>
                <td>${{ $stock->buying_price }}</td>
                <td>${{ $stock->selling_price }}</td>
                <td>{{ $stock->quantity }}</td>
                <td>${{ $stock->profit_per_item }}</td>
                <td>
                    @if($stock->image)
                    <img src="{{ asset('storage/' . $stock->image) }}" class="card-img-top" style="max-width: 150px;" alt="{{ $stock->item_name }}">

                     @else
                        No Image
                    @endif
                </td>
                <td>
                    <button class="btn btn-warning btn-sm edit-stock-btn" data-toggle="modal" data-target="#editStockModal"
                        data-id="{{ $stock->id }}" data-item_name="{{ $stock->item_name }}"
                        data-buying_price="{{ $stock->buying_price }}" data-selling_price="{{ $stock->selling_price }}"
                        data-quantity="{{ $stock->quantity }}">Edit</button>
                    <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</div>

 <!-- Add Stock Modal -->
<div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStockModalLabel">Add Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('stocks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="itemName">Item Name</label>
                        <input type="text" class="form-control" id="itemName" name="item_name" required>
                    </div>
                    <div class="form-group">
                        <label for="buyingPrice">Buying Price</label>
                        <input type="number" class="form-control" id="buyingPrice" name="buying_price" required>
                    </div>
                    <div class="form-group">
                        <label for="sellingPrice">Selling Price</label>
                        <input type="number" class="form-control" id="sellingPrice" name="selling_price" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Item Image</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Stock Modal -->
<div class="modal fade" id="editStockModal" tabindex="-1" aria-labelledby="editStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStockModalLabel">Edit Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editStockForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editStockId" name="id">
                    <div class="form-group">
                        <label for="editItemName">Item Name</label>
                        <input type="text" class="form-control" id="editItemName" name="item_name" required>
                    </div>
                    <div class="form-group">
                        <label for="editBuyingPrice">Buying Price</label>
                        <input type="number" class="form-control" id="editBuyingPrice" name="buying_price" required>
                    </div>
                    <div class="form-group">
                        <label for="editSellingPrice">Selling Price</label>
                        <input type="number" class="form-control" id="editSellingPrice" name="selling_price" required>
                    </div>
                    <div class="form-group">
                        <label for="editQuantity">Quantity</label>
                        <input type="number" class="form-control" id="editQuantity" name="quantity" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Fill the edit form with current item details
    $('.edit-stock-btn').on('click', function () {
        var id = $(this).data('id');
        var item_name = $(this).data('item_name');
        var buying_price = $(this).data('buying_price');
        var selling_price = $(this).data('selling_price');
        var quantity = $(this).data('quantity');

        $('#editStockId').val(id);
        $('#editItemName').val(item_name);
        $('#editBuyingPrice').val(buying_price);
        $('#editSellingPrice').val(selling_price);
        $('#editQuantity').val(quantity);

        $('#editStockForm').attr('action', '/stocks/' + id);
    });
});
</script>
@endsection
