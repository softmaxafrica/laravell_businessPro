@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Expenses</h1>

    <!-- Button to toggle expense form visibility -->
    <button id="toggleExpenseForm" class="btn btn-secondary mb-3">Add New Expense</button>

    <!-- Expense form -->
    <form id="expenseForm" method="POST" action="{{ route('expenses.store') }}" style="display: none;">
        @csrf
        <div class="form-group">
            <label for="transactionDate">Date of Transaction</label>
            <input type="date" class="form-control" id="transactionDate" name="date_of_transaction" required>
        </div>
        <div class="form-group">
            <label for="amountUsed">Amount Used</label>
            <input type="number" class="form-control" id="amountUsed" name="amount_used" placeholder="Enter amount used" required>
        </div>
        <div class="form-group">
            <label for="reasonForExpense">Reason for Expense</label>
            <textarea class="form-control" id="reasonForExpense" name="reason_for_expense" rows="3" placeholder="Enter reason for expense" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <!-- Expenses table -->
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Date of Transaction</th>
                <th>Amount Used</th>
                <th>Reason for Expense</th>
            </tr>
        </thead>
        <tbody id="expensesTableBody">
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->date_of_transaction }}</td>
                    <td>{{ $expense->amount_used }}</td>
                    <td>{{ $expense->reason_for_expense }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Include jQuery for handling toggle and form submission -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Toggle form visibility
        $('#toggleExpenseForm').click(function() {
            $('#expenseForm').toggle(); // Toggle visibility of the form
        });
    });
</script>
@endsection
