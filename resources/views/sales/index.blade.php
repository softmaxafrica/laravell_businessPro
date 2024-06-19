@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sales Management</h1>
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" class="form-control" id="searchInput" placeholder="Search items...">
        </div>
    </div>
    <div class="row" id="stockContainer">
        @foreach($stocks as $stock)
        <div class="col-md-4 mb-3 stock-card" data-name="{{ $stock->item_name }}">
            <div class="card">
                @if($stock->image)
                <img src="{{ asset('storage/' . $stock->image) }}" class="card-img-top" style="max-width: 150px;" alt="{{ $stock->item_name }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $stock->item_name }}</h5>
                    <p class="card-text"><strong>Buying Price:</strong> ${{ $stock->buying_price }}</p>
                    <p class="card-text"><strong>Selling Price:</strong> ${{ $stock->selling_price }}</p>
                    <p class="card-text"><strong>Available Quantity:</strong> {{ $stock->quantity }}</p>
                    <button class="btn btn-primary sell-item-btn" 
                            data-id="{{ $stock->id }}" 
                            data-item_name="{{ $stock->item_name }}"
                            data-selling_price="{{ $stock->selling_price }}"
                            data-buying_price="{{ $stock->buying_price }}">Sell Item</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Sell Item Modal -->
<div class="modal fade" id="sellItemModal" tabindex="-1" aria-labelledby="sellItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sellItemModalLabel">Sell Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="sellItemForm" action="{{ route('sales.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="sellItemId" name="stock_id">
                    <input type="hidden" id="sellItemName" name="item_name">
                    <input type="hidden" id="sellBuyingPrice" name="buying_price">
                    <div class="form-group">
                        <label for="sellQuantity">Quantity</label>
                        <input type="number" class="form-control" id="sellQuantity" name="quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="sellPrice">Sale Price</label>
                        <input type="number" class="form-control" id="sellPrice" name="sale_price" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Record Sale</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const stockContainer = document.getElementById('stockContainer');
    const stockCards = document.querySelectorAll('.stock-card');

    searchInput.addEventListener('input', function () {
        const searchTerm = searchInput.value.toLowerCase();
        stockCards.forEach(card => {
            const itemName = card.dataset.name.toLowerCase();
            if (itemName.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    $('.sell-item-btn').on('click', function () {
        const itemId = $(this).data('id');
        const itemName = $(this).data('item_name');
        const sellingPrice = $(this).data('selling_price');
        const buyingPrice = $(this).data('buying_price');

        $('#sellItemId').val(itemId);
        $('#sellItemName').val(itemName);
        $('#sellBuyingPrice').val(buyingPrice);
        $('#sellPrice').val(sellingPrice);

        $('#sellItemModal').modal('show');
    });
});
</script>
@endsection
