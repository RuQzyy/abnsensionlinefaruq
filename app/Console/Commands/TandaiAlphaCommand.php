<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AbsensiController;

class TandaiAlphaCommand extends Command
{
    protected $signature = 'absensi:tandai-alpha';
    protected $description = 'Menandai siswa alpha dan bolos setiap hari';

    public function handle()
    {
        $controller = new AbsensiController();
        $controller->tandaiAlphaDanBolos();

        $this->info('Selesai menandai alpha dan bolos.');
    }
}

