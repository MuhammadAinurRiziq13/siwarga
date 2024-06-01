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
        Schema::create('warga', function (Blueprint $table) {
            $table->string('NIK')->primary();
            $table->string('noKK', 20);
            $table->string('nama', 40);
            $table->string('tempat_lahir', 30);
            $table->date('tanggal_lahir');
            $table->char('jenis_kelamin', 10);
            $table->string('agama', 10);
            $table->string('status_pernikahan', 15);
            $table->string('status_keluarga', 20);
            $table->string('status_kerja', 20);
            // $table->boolean('kepala_keluarga')->default(false);
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
        Schema::dropIfExists('warga');
    }
};
