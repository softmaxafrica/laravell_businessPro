<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_email',
        'date_of_transaction',
        'amount_used',
        'reason_for_expense'
    ];

    protected $dates = ['date_of_transaction', 'updated_at'];

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
