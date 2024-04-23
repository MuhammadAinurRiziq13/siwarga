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
        Schema::create('bukti_pengajuan_edit_data_warga', function (Blueprint $table) {
            $table->string("NIK_pengajuan");
            $table->string("nama_bukti");
            $table->timestamps();

            $table->foreign('NIK_pengajuan')->references('NIK_pengajuan')->on('pengajuanEditDataWarga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_pengajuan_edit_data_warga');
    }
};
