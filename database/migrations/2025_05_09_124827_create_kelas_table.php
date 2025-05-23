<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id('id_kelas'); 
            $table->string('nama_kelas', 255);
           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
