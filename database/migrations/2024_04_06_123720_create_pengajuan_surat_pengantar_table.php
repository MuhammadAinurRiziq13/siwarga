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
        Schema::create('pengajuansuratpengantar', function (Blueprint $table) {
            $table->id();
            $table->string('NIK');
            $table->string('pekerjaan');
            $table->string('pendidikan');
            $table->string('no_hp');
            $table->string('keperluan');
            $table->string('status');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('NIK')->references('NIK')->on('warga')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuansuratpengantar');
    }
};
