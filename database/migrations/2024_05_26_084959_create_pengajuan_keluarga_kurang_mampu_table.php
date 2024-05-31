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
        Schema::create('pengajuanprasejahtera', function (Blueprint $table) {
            $table->id();
            $table->string('noKK');
            $table->string('jumlah_tanggungan');
            $table->string('kondisi_rumah');
            $table->string('luas_tanah');
            $table->string('aset_kendaraan');
            $table->string('pendapatan');
            $table->string('status');
            $table->string('no_hp');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('noKK')->references('noKK')->on('keluarga')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuanprasejahtera');
    }
};