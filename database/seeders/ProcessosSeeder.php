<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ProcessosSeeder extends Seeder
{
    public function run()
    {
        $path = database_path('data/processos.json');
        $json = File::get($path);
        $processos = json_decode($json, true);

        $chunks = array_chunk($processos, 100);

        foreach ($chunks as $chunk) {
            DB::table('processos')->insert($chunk);
        }

        $this->command->info(count($processos) . " processos inseridos com sucesso.");
    }
}