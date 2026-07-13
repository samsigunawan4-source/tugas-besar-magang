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
        Schema::table('applications', function (Blueprint $table) {
            $table->string('laporan_akhir')->nullable()->after('status');
            $table->string('sertifikat')->nullable()->after('laporan_akhir');
            $table->string('nilai')->nullable()->after('sertifikat');
            $table->date('tgl_selesai_magang')->nullable()->after('nilai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['laporan_akhir', 'sertifikat', 'nilai', 'tgl_selesai_magang']);
        });
    }
};
