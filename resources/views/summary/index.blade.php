@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daily Summary</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Total Sales</th>
                <th>Total Expenses</th>
                <th>Initial Profit</th>
                <th>Net Day Profit / Loss(-)</th>
                <th>AI Suggestion</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dailySummaries as $summary)
            <tr>
                <td>{{ $summary->date }}</td>
                <td>{{ $summary->total_sales }}</td>
                <td>{{ $summary->total_expenses }}</td>
                <td>{{ $summary->total_profit }}</td>
                <td>{{ $summary->net_day_profit }}</td>
                <td>
                    <form class="aiSuggestionForm" action="{{ route('ai.suggest') }}" method="POST">
                        @csrf
                        <input type="hidden" name="date" value="{{ $summary->date }}">
                        <input type="hidden" name="totalSales" value="{{ $summary->total_sales }}">
                        <input type="hidden" name="totalExpenses" value="{{ $summary->total_expenses }}">
                        <input type="hidden" name="totalProfit" value="{{ $summary->total_profit }}">
                        <input type="hidden" name="netDayProfit" value="{{ $summary->net_day_profit }}">
                        <button type="submit" class="btn btn-primary">View Suggestion</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal for displaying AI suggestion -->
<div class="modal fade" id="aiSuggestionModal" tabindex="-1" role="dialog" aria-labelledby="aiSuggestionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aiSuggestionModalLabel">AI Suggestion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="aiSuggestionText"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const aiSuggestionForms = document.querySelectorAll('.aiSuggestionForm');
        const aiSuggestionModal = $('#aiSuggestionModal');

        aiSuggestionForms.forEach(function(form) {
            form.addEventListener('submit', async function(event) {
                event.preventDefault(); // Prevent the form from submitting normally

                const formData = new FormData(this);

                try {
                    const response = await fetch("{{ route('ai.suggest') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    });

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const responseData = await response.json();
                    const suggestion = responseData.suggestion;

                    // Display suggestion in modal
                    const aiSuggestionText = document.getElementById('aiSuggestionText');
                    aiSuggestionText.innerHTML = suggestion.replace(/\n/g, '<br>');
                    aiSuggestionModal.modal('show');
                } catch (error) {
                    console.error('Error fetching AI suggestion:', error);
                    alert('Error fetching AI suggestion.');
                }
            });
        });
    });
</script>

@endsection
