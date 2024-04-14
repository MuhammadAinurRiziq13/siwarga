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
            $table->integer('kriteria1');
            $table->integer('kriteria2');
            $table->integer('kriteria3');
            $table->integer('kriteria4');
            $table->integer('kriteria5');
            $table->timestamps();
        
            $table->foreign('noKK')->references('noKK')->on('keluarga');
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
