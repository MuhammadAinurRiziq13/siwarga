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
        Schema::create('bukti_pengajuan_kurang_mampu', function (Blueprint $table) {
            $table->string("noKK_pengajuan");
            $table->string("nama_bukti");
            $table->timestamps();

            $table->foreign('noKK_pengajuan')->references('noKK_pengajuan')->on('pengajuanKeluargaKurangMampu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_pengajuan_kurang_mampu');
    }
};
