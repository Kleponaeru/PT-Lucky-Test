<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('krs', function (Blueprint $table) {
            $table->id();
            $table->string('m_id', 10); // FK ke mahasiswa
            $table->string('kode_mata_kuliah', 5);
            $table->integer('sks');

            $table->foreign('m_id')->references('m_id')->on('mahasiswa');
            $table->foreign('kode_mata_kuliah')->references('kode_mata_kuliah')->on('mata_kuliah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
