<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryProfit extends Model
{
    use HasFactory;

 
    protected $fillable = [
        'owner',
        'business_name',
        'user_email',
        'date',
        'total_sales',
        'total_expenses',
        'daily_target',
        'total_profit',
        'net_day_profit',
        'deviation',
    ];
    

    // Relationships
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_email', 'email');
    }
}
