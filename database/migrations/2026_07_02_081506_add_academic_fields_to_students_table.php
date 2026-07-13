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
        Schema::table('students', function (Blueprint $table) {
            $table->string('no_wa')->nullable()->after('prodi');
            $table->integer('semester')->nullable()->after('no_wa');
            $table->integer('jumlah_sks')->nullable()->after('semester');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['no_wa', 'semester', 'jumlah_sks']);
        });
    }
};
