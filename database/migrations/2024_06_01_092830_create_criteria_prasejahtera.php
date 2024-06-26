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
        Schema::create('criteriaprasejahtera', function (Blueprint $table) {
            $table->id();
            $table->string('kode',5)->unique();
            $table->string('nama',30);
            $table->double('bobot');
            $table->enum('jenis', ['cost', 'benefit']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criteriaprasejahtera');
    }
};
