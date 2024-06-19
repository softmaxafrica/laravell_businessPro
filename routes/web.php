<?php
use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SummaryProfitController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\AiController;

Route::get('/', function () {
    return redirect('login');
});
Route::get('dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::post('business', [BusinessController::class, 'store'])->name('business.store');


Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('sales', [SalesController::class, 'index'])->name('sales.index');
    Route::resource('sales', SalesController::class);
    Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::resource('stocks', StockController::class);

    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
     
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('summary', [SummaryProfitController::class, 'index'])->name('summary.index');
    Route::get('/daily-summary', [SummaryProfitController::class, 'index'])->name('daily.summary');

    Route::get('business', [BusinessController::class, 'index'])->name('business.index');
     Route::post('/ai/suggest', [AiController::class, 'getSuggestions'])->name('ai.suggest');
 
     Route::get('/suggestion', [AiController::class, 'getSuggestions'])->name('suggestion');
     Route::post('/ai/followup', [AiController::class, 'postFollowUp'])->name('ai.followup');

      Route::post('/ai/suggest', [AiController::class, 'getSuggestions'])->name('ai.suggest');
 
     Route::get('/suggestion', [AiController::class, 'getSuggestions'])->name('suggestion');
     Route::post('/ai/followup', [AiController::class, 'postFollowUp'])->name('ai.followup');

});
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

