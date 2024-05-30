<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuario = new User();
        $usuario->name='david';
        $usuario->slug=Str::slug($usuario->name);
        $usuario->email = 'david@educantabria.es';
        $usuario->password = Hash::make('usuario@1');
        $usuario->save();

        $usuario = new User();
        $usuario->name='prueba1';
        $usuario->slug=Str::slug($usuario->name);
        $usuario->email = 'prueba1@educantabria.es';
        $usuario->password = Hash::make('usuario@1');
        $usuario->save();
    }
}
