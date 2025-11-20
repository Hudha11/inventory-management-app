<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        // Contoh: buat 50 item random via factory
        Item::factory()->count(50)->create();

        // Jika mau kombinasi: beberapa manual + beberapa factory
        Item::create([
            'sku' => 'SKU-0000',
            'name' => 'Stock Default Item',
            'price' => 15000.00,
            'stock_quantity' => 50,
            'reserved_quantity' => 5,
        ]);
    }
}
