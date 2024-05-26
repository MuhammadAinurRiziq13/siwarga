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
        Schema::create('bukti_pengajuan_prasejahtera', function (Blueprint $table) {
            $table->string("noKK");
            $table->string("nama_bukti");
            $table->timestamps();

            $table->foreign('noKK')->references('noKK')->on('pengajuanprasejahtera');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_pengajuan_prasejahtera');
    }
};
