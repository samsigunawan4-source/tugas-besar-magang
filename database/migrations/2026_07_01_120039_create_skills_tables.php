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
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('skill_student', function (Blueprint $table) {
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->primary(['skill_id', 'student_id']);
        });

        Schema::create('skill_vacancy', function (Blueprint $table) {
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->foreignId('vacancy_id')->constrained()->onDelete('cascade');
            $table->primary(['skill_id', 'vacancy_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skill_vacancy');
        Schema::dropIfExists('skill_student');
        Schema::dropIfExists('skills');
    }
};
