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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('sku')->unique(); // Unique stock keeping unit
            $table->string('name'); // e.g., "Red / XL"
            $table->decimal('price', 12, 2)->nullable(); // Overrides base product price
            $table->integer('stock')->default(0);
            $table->json('attributes')->nullable(); // Store metadata like ['color' => 'Red', 'size' => 'XL']
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
