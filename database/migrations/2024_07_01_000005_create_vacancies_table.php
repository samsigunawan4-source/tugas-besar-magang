<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->string('posisi');
            $table->text('deskripsi');
            $table->text('kualifikasi');
            $table->integer('kuota');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->date('batas_daftar');
            $table->string('dokumen_pdf')->nullable(); // KAK/ToR
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vacancies');
    }
};
