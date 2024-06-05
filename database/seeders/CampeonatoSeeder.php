<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Carrera;
use App\Models\Campeonato;


class CampeonatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear algunos campeonatos
        $campeonato1 = Campeonato::create([
            'nombre' => 'Campeonato de Verano',
            'fecha' => '2024-06-01',
            'usuario_id' => 1,
            'en_curso' => true,
            'slug' => Str::slug('Campeonato de Verano'),
        ]);

        $campeonato2 = Campeonato::create([
            'nombre' => 'Campeonato de Invierno',
            'fecha' => '2024-12-01',
            'usuario_id' => 1,
            'en_curso' => false,
            'slug' => Str::slug('Campeonato de Invierno'),
        ]);

        $campeonato3 = Campeonato::create([
            'nombre' => 'Campeonato de Primavera',
            'fecha' => '2024-03-01',
            'usuario_id' => 1,
            'en_curso' => false,
            'slug' => Str::slug('Campeonato de Primavera'),
        ]);

        // Insertar relaciones en la tabla intermedia
        DB::table('campeonato_carrera')->insert([
            ['campeonato_id' => $campeonato1->id, 'carrera_id' => 1],
            ['campeonato_id' => $campeonato1->id, 'carrera_id' => 2],
            ['campeonato_id' => $campeonato2->id, 'carrera_id' => 3],
            ['campeonato_id' => $campeonato2->id, 'carrera_id' => 1],
            ['campeonato_id' => $campeonato3->id, 'carrera_id' => 5],
            ['campeonato_id' => $campeonato3->id, 'carrera_id' => 6],
        ]);
    }
}
