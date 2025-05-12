<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id('id_pengumuman'); 
            $table->string('judul', 255); 
            $table->string('isi', 255);
           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
    }
};
