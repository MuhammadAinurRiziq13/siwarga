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
        Schema::create('pengajuanEditDataWarga', function (Blueprint $table) {
            $table->string('NIK_pengajuan')->primary();
            $table->string('nama',30);
            $table->string('tempat_lahir',30);
            $table->date('tanggal_lahir');
            $table->char('jenis_kelamin',1);
            $table->string('agama',10);
            $table->string('status_pernikahan',15);
            $table->string('keterangan',50);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuanEditDataWarga');
    }
};
