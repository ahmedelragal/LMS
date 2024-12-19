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
        Schema::create('student_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // Link to the student
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade'); // Link to the teacher
            $table->integer('attendance_score')->nullable(); // Score for attendance
            $table->integer('classroom_participation_score')->nullable(); // Score for classroom participation
            $table->integer('classroom_behavior_score')->nullable(); // Score for classroom behavior
            $table->integer('homework_score')->nullable(); // Score for homework
            $table->integer('final_project_score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_assessments');
    }
};
