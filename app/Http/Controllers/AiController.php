<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Sale;
use App\Models\Expense;

class AiController extends Controller
{
    public function getSuggestions(Request $request)
    {
        try {
            // Fetch necessary data from request
            $date = $request->input('date');
            $totalSales = $request->input('totalSales');
            $totalExpenses = $request->input('totalExpenses');
            $totalProfit = $request->input('totalProfit');
            $netDayProfit = $request->input('netDayProfit');

            // Retrieve sales and expenses data for the given date
            $sales = Sale::whereDate('date_of_transaction', $date)->get();
            $expenses = Expense::whereDate('date_of_transaction', $date)->get();

            // Prepare the prompt
            $prompt = $this->generatePrompt($date, $sales, $expenses, $totalSales, $totalExpenses, $totalProfit, $netDayProfit);

            // Prepare the payload for the AI API request
            $payload = [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a business data analyst and advisor.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => 1000,
            ];

            $client = new Client();

            $headers = [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ];

            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => $headers,
                'json' => $payload,
            ]);

            $result = json_decode($response->getBody(), true);

            // Extract and return the AI's suggestion
            $suggestion = $result['choices'][0]['message']['content'] ?? 'No suggestion available.';

            return view('suggestion', ['suggestion' => $suggestion]);

        } catch (\Exception $e) {
            \Log::error('Error fetching AI suggestion: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching AI suggestion.'], 500);
        }
    }

    public function postFollowUp(Request $request)
    {
        try {
            $question = $request->input('question');
            $suggestion = $request->input('suggestion');

            // Prepare the payload for the AI API request
            $payload = [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a business data analyst and advisor.'],
                    ['role' => 'user', 'content' => $suggestion . "\nUser Question: " . $question],
                ],
                'max_tokens' => 1000,
            ];

            $client = new Client();

            $headers = [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ];

            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => $headers,
                'json' => $payload,
            ]);

            $result = json_decode($response->getBody(), true);

            // Extract and return the AI's response
            $answer = $result['choices'][0]['message']['content'] ?? 'No response available.';

            return response()->json(['answer' => $answer]);

        } catch (\Exception $e) {
            \Log::error('Error fetching follow-up response: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching follow-up response.'], 500);
        }
    }

    private function generatePrompt($date, $sales, $expenses, $totalSales, $totalExpenses, $totalProfit, $netDayProfit)
    {
        $prompt = "You are the business Data Analyst and Advisor for this system (Business Pro). Use the following business data and provide detailed comprehensive suggestions to reach the target of the business:\n";
        $prompt .= "Date: {$date}\n";
        $prompt .= "\nSales Data:\n";
        foreach ($sales as $sale) {
            $prompt .= "Item Name: {$sale->item_name}, Quantity: {$sale->quantity}, Sale Price: {$sale->sale_price}, Total Price: {$sale->total_price}, Total Profit: {$sale->total_profit}\n";
        }
        $prompt .= "\nExpenses Data:\n";
        foreach ($expenses as $expense) {
            $prompt .= "Amount Used: {$expense->amount_used}, Reason: {$expense->reason_for_expense}\n";
        }

        $prompt .= "\nTotal Sales: {$totalSales}\n";
        $prompt .= "Total Expenses: {$totalExpenses}\n";
        $prompt .= "Total Profit: {$totalProfit}\n";
        $prompt .= "Net Day Profit: {$netDayProfit}\n";

        return $prompt;
    }
}
