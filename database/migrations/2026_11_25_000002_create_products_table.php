<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('barcode', 20)->unique();
            $table->string('title');
            $table->string('platform')->nullable();
            $table->string('author_publisher')->nullable();
            $table->year('release_year')->nullable();
            $table->string('cover_url')->nullable();
            $table->string('source', 30)->nullable();
            $table->enum('status', ['published', 'pending', 'review'])->default('pending');
            $table->foreignId('category_id')->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
