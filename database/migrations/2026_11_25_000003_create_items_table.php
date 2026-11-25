<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->decimal('purchase_price', 8, 2)->nullable();
            $table->decimal('estimated_value', 8, 2)->nullable();
            $table->date('acquired_at')->nullable();
            $table->enum('state', ['new', 'used']);
            $table->enum('format', ['physical', 'digital'])->default('physical');
            $table->string('location', 50)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
