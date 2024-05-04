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
        Schema::create('keluargaKurangMampu', function (Blueprint $table) {
            $table->string('noKK');
            $table->integer('jumlah_tanggungan');
            $table->integer('pendapatan');
            $table->integer('jumlah_kendaraan');
            $table->integer('luas_tanah');
            $table->integer('kondisi_rumah');
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
        Schema::dropIfExists('keluargaKurangMampu');
    }
};
