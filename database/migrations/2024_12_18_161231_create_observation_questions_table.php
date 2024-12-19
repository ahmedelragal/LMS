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
        Schema::create('observation_questions', function (Blueprint $table) {
            $table->id();
            $table->text('question')->nullable();
            $table->integer('max_rate')->default(4);
            $table->foreignId('observation_header_id')->constrained()->on('observation_headers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observation_questions');
    }
};
