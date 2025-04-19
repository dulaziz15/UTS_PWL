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
        Schema::create('mobil', function (Blueprint $table) {
            $table->id('mobil_id');
            $table->unsignedBigInteger('kategori_id')->index();
            $table->string('merk');
            $table->integer('tahun');
            $table->integer('harga');
            $table->string('type');
            $table->string('image');
            $table->string('status');
            $table->timestamps();

            $table->foreign('kategori_id')->references('kategori_id')->on('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobil');
    }
};
