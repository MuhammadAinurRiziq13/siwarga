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
        Schema::create('bukti_prasejahtera', function (Blueprint $table) {
            $table->bigInteger("bukti")->unsigned();
            $table->string("nama_bukti", 100);
            $table->timestamps();

            $table->foreign('bukti')->references('id')->on('keluargaKurangMampu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_prasejahtera');
    }
};