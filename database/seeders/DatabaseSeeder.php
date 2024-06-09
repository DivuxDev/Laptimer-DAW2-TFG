<?php

namespace Database\Seeders;

use App\Models\Jugador;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('usuarios')->delete();
        $this->call(UserSeeder::class);
        $this->call(EquipoSeeder::class);
        $this->call(DispositivoSeeder::class);
        $this->call(CocheSeeder::class);
        Jugador::factory()->count(10)->create();     
        $this->call(CarrerasSeeder::class);
        $this->call(ParticipacionSeeder::class);
        $this->call(TiempoSeeder::class);
        $this->call(CampeonatoSeeder::class);
    }
}
