<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained()
                ->onDelete('restrict'); // atau cascade sesuai business rule
            $table->string('sku')->unique();
            $table->string('name');
            $table->decimal('price', 12, 2)->default(0);
            $table->integer('stock_quantity')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes(); // opsional menambahkan deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
