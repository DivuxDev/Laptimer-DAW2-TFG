<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dispositivo;
use Illuminate\Support\Str;

class DispositivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dispositivo = new Dispositivo();
        $dispositivo->mac='e4:5f:01:89:30:de';
        $dispositivo->slug=Str::slug($dispositivo->mac);
        $dispositivo->nombre='LAPTIMER NUMERO 1';
        $dispositivo->usuario_id=1;
        $dispositivo->save();

        $dispositivo = new Dispositivo();
        $dispositivo->mac='e4:5f:01:89:30:fe';
        $dispositivo->slug=Str::slug($dispositivo->mac);
        $dispositivo->nombre='LAPTIMER NUMERO 2';
        $dispositivo->usuario_id=2;
        $dispositivo->save();

    }
}
