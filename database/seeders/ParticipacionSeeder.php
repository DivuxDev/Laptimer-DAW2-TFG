<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Participacion;
use App\Models\Jugador;
use App\Models\Carrera;
use App\Models\Coche;

class ParticipacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los jugadores, carreras y coches
        $jugadores = Jugador::all();
        $carreras = Carrera::all();
        $coches = Coche::all();

        // Crear participaciones aleatorias
        foreach ($carreras as $carrera) {
            foreach ($jugadores as $jugador) {
                // Seleccionar un coche aleatorio para cada participación
                $coche = $coches->random();

                Participacion::create([
                    'id_jugador' => $jugador->id,
                    'id_carrera' => $carrera->id,
                    'id_coche' => $coche->id,
                ]);
            }
        }
    }
}
