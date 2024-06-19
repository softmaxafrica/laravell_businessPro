@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Business Description</h1>
    @if($business)
        <p><strong>Owner:</strong> {{ $business->owner }}</p>
        <p><strong>Business Name:</strong> {{ $business->name }}</p>
        <p><strong>Business Period (days):</strong> {{ $business->business_period_days }}</p>
        <p><strong>Expected Profit:</strong> ${{ $business->expected_profit }}</p>
        <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($business->start_date)->format('Y-m-d') }}</p>
        <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($business->end_date)->format('Y-m-d') }}</p>
    @else
        <h3>Add Business Details</h3>
        <form method="POST" action="{{ route('business.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Business Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            <div class="form-group">
                <label for="expected_profit">Expected Profit</label>
                <input type="number" step="0.01" class="form-control" id="expected_profit" name="expected_profit" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection
