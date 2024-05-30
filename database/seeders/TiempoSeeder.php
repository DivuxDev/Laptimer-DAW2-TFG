<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tiempo;
use App\Models\Participacion;

class TiempoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener las participaciones de la primera carrera
        $participaciones = Participacion::where('id_carrera', 1)->get();

        // Generar tiempos aleatorios para cada participación
        foreach ($participaciones as $participacion) {
            for ($i = 1; $i <= 5; $i++) { // Suponiendo que cada participación tiene 5 tiempos
                Tiempo::create([
                    'participacion_id' => $participacion->id,
                    'vuelta' => $i,
                    'tiempo' => rand(100, 200) / 10, // Genera un tiempo aleatorio entre 10.0 y 20.0 segundos
                ]);
            }
        }
    }
}
