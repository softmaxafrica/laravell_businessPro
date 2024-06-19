<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'business_days', 'expected_profit'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $timestamps = false;

    // Relationships
    public function business()
    {
        return $this->hasOne(Business::class, 'owner', 'email'); // Adjust if 'owner' is not the foreign key
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'user_email', 'email'); // Ensure 'user_email' is correctly set if needed
    }

    public function sales()
    {
        return $this->hasMany(Sale::class); // Adjust based on your actual setup
    }

    public function summaryProfits()
    {
        return $this->hasMany(SummaryProfit::class, 'user_email', 'email'); // Ensure 'user_email' is correctly set if needed
    }
}
