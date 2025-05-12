<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id('id_pengaturan'); 
            $table->string('nama_project', 255); 
            $table->time('absen_datang');
            $table->time('absen_pulang');
            $table->string('long_lokasi', 255);
            $table->string('lath_lokasi', 255);
           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};
