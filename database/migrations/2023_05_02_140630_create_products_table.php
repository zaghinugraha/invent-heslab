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
        Schema::create('products', function (Blueprint $table) {
            $table->timestamps();
            $table->id();
            $table->uuid();
            $table->foreignId("user_id")->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->string('code');
            $table->integer('price');
            //$table->string('product_barcode_symbology')->nullable();
            $table->integer('quantity');
            $table->integer('quantity_alert');
            $table->string('brand');
            $table->text('notes')->nullable();
            $table->longText('specification')->nullable();
            $table->string('source');
            $table->date('dateArrival')->nullable();
            $table->boolean('is_rentable')->default(false);

            $table->foreignIdFor(\App\Models\Category::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();
        });
        DB::statement("ALTER TABLE products ADD product_image MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
