<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner', 'item_name', 'buying_price', 'selling_price', 'quantity', 'profit_per_item','image'
    ];

    protected $dates = ['created_at', 'updated_at'];

    // Define the relationship with the Business model
    public function business()
    {
        return $this->belongsTo(Business::class, 'owner', 'owner'); // Adjust if 'owner' is not the foreign key
    }
}
