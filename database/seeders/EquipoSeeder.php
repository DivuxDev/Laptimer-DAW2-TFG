<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Equipo;
use Illuminate\Support\Str;
class EquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipo = new Equipo;
        $equipo->nombre='Ferrari';
        $equipo->descripcion='Equipo de prueba 1';
        $equipo->slug=Str::slug($equipo->nombre);
        $equipo->usuario_id=1;
        $equipo->save();

        $equipo = new Equipo;
        $equipo->nombre='Masseratti';
        $equipo->descripcion='Equipo de prueba 2';
        $equipo->slug=Str::slug($equipo->nombre);
        $equipo->usuario_id=1;
        $equipo->save();

        $equipo = new Equipo;
        $equipo->nombre='MClAREN';
        $equipo->descripcion='Equipo de prueba 3';
        $equipo->slug=Str::slug($equipo->nombre);
        $equipo->usuario_id=2;
        $equipo->save();
    }
}
