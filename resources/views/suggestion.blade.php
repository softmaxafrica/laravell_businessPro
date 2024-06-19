<!-- suggestion.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4">AI Suggestions</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">AI Suggestion</h5>
            <p class="card-text">{{ $suggestion }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Ask a Follow-up Question</h5>
            <form id="followUpForm">
                <div class="form-group">
                    <label for="followUpQuestion">Your Question:</label>
                    <input type="text" class="form-control" id="followUpQuestion" name="followUpQuestion" required>
                    <input type="hidden" id="suggestion" name="suggestion" value="{{ $suggestion }}">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <div id="followUpResponse" class="mt-4"></div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const followUpForm = document.getElementById('followUpForm');
        const followUpResponse = document.getElementById('followUpResponse');

        followUpForm.addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            try {
                const response = await fetch("{{ route('ai.followup') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        question: formData.get('followUpQuestion'),
                        suggestion: formData.get('suggestion')
                    })
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const responseData = await response.json();

                // Display the follow-up response
                followUpResponse.innerHTML = `
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">AI Response</h5>
                            <p class="card-text">${responseData.answer}</p>
                        </div>
                    </div>
                `;
            } catch (error) {
                console.error('Error submitting follow-up question:', error);
                alert('Error submitting follow-up question.');
            }
        });
    });
</script>
@endsection
