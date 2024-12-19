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
        Schema::table('student_assessments', function (Blueprint $table) {
            $table->unsignedBigInteger('assignment_student_id')->nullable();
            $table->foreign('assignment_student_id')->references('id')->on('assignment_student')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_assessments', function (Blueprint $table) {
            //
        });
    }
};
