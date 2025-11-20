<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Testing\Fluent\Concerns\Has;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['sku', 'name', 'price', 'stock_quantity', 'reserved_quantity'];
    // protected $guarded = [];

    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class);
    // }
}
