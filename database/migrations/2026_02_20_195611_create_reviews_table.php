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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('integration_id')->constrained()->cascadeOnDelete();
            $table->string('external_id');
            $table->string('author_name');
            $table->integer('rating');
            $table->text('text')->nullable();
            $table->timestamp('published_at');
            $table->json('raw')->nullable();
            $table->timestamps();
            $table->unique(['integration_id', 'external_id']);
            $table->index('published_at');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
