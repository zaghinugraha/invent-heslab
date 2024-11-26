<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rent_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')
                ->constrained('products')
                ->cascadeOnDelete();
            $table->foreignId('rent_id')
                ->constrained('rent')
                ->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('price_per_unit', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_items');
    }
};
