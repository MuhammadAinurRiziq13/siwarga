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
        Schema::create('pengajuanKeluargaKurangMampu', function (Blueprint $table) {
            $table->string('noKK_pengajuan')->primary();
            $table->integer('kriteria1');
            $table->integer('kriteria2');
            $table->integer('kriteria3');
            $table->integer('kriteria4');
            $table->integer('kriteria5');
            $table->string('bukti',20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuanKeluargaKurangMampu');
    }
};
