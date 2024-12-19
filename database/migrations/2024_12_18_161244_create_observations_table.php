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
        Schema::create('observations', function (Blueprint $table) {
            $table->id();
            $table->text('teacher_name')->nullable();
            $table->text('teacher_email')->nullable();
            $table->text('course_title')->nullable();
            $table->foreignId('observer_id')->constrained()->on('observers')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained()->on('teachers')->onDelete('cascade');
            $table->foreignId('stage_id')->constrained()->on('stages')->onDelete('cascade');
            $table->foreignId('material_id')->constrained()->on('materials')->onDelete('cascade');
            $table->foreignId('school_id')->constrained()->on('schools')->onDelete('cascade');
            $table->date('activity')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('status')->nullable();
            $table->json('lesson_segment')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observations');
    }
};
