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
        Schema::create('detail_mobil', function (Blueprint $table) {
            $table->id('detail_mobil_id');
            $table->unsignedBigInteger('mobil_id')->index();
            $table->integer('usia');
            $table->integer('kilometer');
            $table->integer('cylinder');
            $table->string('no_mesin');
            $table->string('transmisi');
            $table->integer('hp');
            $table->string('warna');
            $table->timestamps();

            $table->foreign('mobil_id')->references('mobil_id')->on('mobil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_mobil');
    }
};
