<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    protected $fillable = ['sku', 'name', 'price', 'stock_quantity', 'reserved_quantity'];
    // protected $guarded = [];

    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class);
    // }
}
