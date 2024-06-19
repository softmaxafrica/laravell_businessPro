<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'owner',
        'user_id',
        'item_name',
        'quantity',
        'sale_price',
        'total_price',
        'total_profit',
        'date_of_transaction'
     ];

    protected $dates = ['date_of_transaction', 'updated_at'];

    // Relationships
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
