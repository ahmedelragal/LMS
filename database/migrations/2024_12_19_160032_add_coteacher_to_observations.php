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
        Schema::table('observations', function (Blueprint $table) {
            // Add coteacher_id column as a foreign key
            $table->foreignId('coteacher_id')
                ->nullable()
                ->constrained('teachers')
                ->onDelete('cascade');

            // Add teacher_name and teacher_email columns
            $table->text('coteacher_name')->nullable();
            $table->text('coteacher_email')->nullable();
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
