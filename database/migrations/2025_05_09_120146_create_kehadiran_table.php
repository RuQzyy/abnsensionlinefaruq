<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kehadiran', function (Blueprint $table) {
            $table->id('id_kehadiran'); 
            $table->integer('id_users'); 
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('foto', 255);
            $table->string('lokasi', 255);

           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kehadiran');
    }
};
