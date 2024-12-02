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
        // Migration untuk tabel rent
        Schema::create('rent', function (Blueprint $table) {
            $table->id();
            $table->string('nim_nip');
            $table->string('phone');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('order_date');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('return_date')->nullable();
            $table->decimal('total_cost', 10, 2);
            $table->string('payment_status');
            $table->string('order_status');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE rent ADD ktm_image MEDIUMBLOB");
        DB::statement("ALTER TABLE rent ADD before_documentation MEDIUMBLOB");
        DB::statement("ALTER TABLE rent ADD after_documentation MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent');
    }
};
