<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner', 'name', 'business_period_days', 'expected_profit', 'start_date', 'end_date'
    ];

    protected $dates = ['start_date', 'end_date'];

    // Accessor for calculating daily_profit_required
    public function getDailyProfitRequiredAttribute()
    {
        $totalDays = $this->start_date->diffInDays($this->end_date) + 1; // Include start and end dates
        return $totalDays > 0 ? $this->expected_profit / $totalDays : 0;
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'owner', 'email'); // 'owner' is the foreign key
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'user_email', 'owner');  
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'owner', 'owner'); // Adjust this if 'owner' is your foreign key
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'owner', 'owner'); // Adjust this if 'owner' is your foreign key
    }

    public function summaryProfits()
    {
        return $this->hasMany(SummaryProfit::class, 'user_email', 'owner'); // Adjust this if 'owner' is your foreign key
    }
}
