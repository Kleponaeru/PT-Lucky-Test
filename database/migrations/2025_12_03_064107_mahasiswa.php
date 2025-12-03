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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->string('m_id', 10)->primary(); // M1, M2, ...
            $table->string('nim');
            $table->string('kode_jns_kelamin', 1);
            $table->string('nama');
            $table->string('jurusan');
            $table->decimal('ipk', 3, 2);
            $table->foreign('kode_jns_kelamin')->references('kode_jns_kelamin')->on('jenis_kelamin');
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
