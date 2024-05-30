<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coche;
use Illuminate\Support\Str;

class CocheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Recorrer array de aulas
        foreach ($this->coches as $coche) {
            //Creacion del modelo de carrera para rellenar la base de datos
            $cocheObj = new Coche();
            $cocheObj->marca = $coche['marca'];
            $cocheObj->modelo = $coche['modelo'];
            $cocheObj->slug = Str::slug($cocheObj->modelo);
            $cocheObj->categoria = $coche['categoria'];
            $cocheObj->usuario_id = $coche['usuario_id'];
            $cocheObj->save();
        }
    }
    
    private $coches = array(
        array(
            'marca' => 'ninco',
            'modelo' => 'Seat Ibiza',
            'categoria' => 'WRC',
            'usuario_id' => 1,
        ),
        array(
            'marca' => 'Scalextric',
            'modelo' => 'Peugeot 205 GTI',
            'categoria' => 'Group B',
            'usuario_id' => 1,
        ),
        array(
            'marca' => 'scaleauto',
            'modelo' => 'Hyundai I30N',
            'categoria' => 'WRC',
            'usuario_id' => 1,
        ),
        array(
            'marca' => 'Carrera',
            'modelo' => 'Porsche 911',
            'categoria' => 'Group 4',
            'usuario_id' => 1,
        ),
        array(
            'marca' => 'Ninco',
            'modelo' => 'Ferrari F40',
            'categoria' => 'Group B',
            'usuario_id' => 1,
        ),
        array(
            'marca' => 'Scalextric',
            'modelo' => 'Ford Mustang',
            'categoria' => 'Group A',
            'usuario_id' => 1,
        ),
        array(
            'marca' => 'Carrera',
            'modelo' => 'BMW M3',
            'categoria' => 'Group A',
            'usuario_id' => 1,
        ),
        array(
            'marca' => 'Fly',
            'modelo' => 'Chevrolet Corvette',
            'categoria' => 'Group 4',
            'usuario_id' => 1,
        ),
        array(
            'marca' => 'Slot.it',
            'modelo' => 'Audi R8',
            'categoria' => 'Group GT',
            'usuario_id' => 1,
        ),
        array(
            'marca' => 'Scalextric',
            'modelo' => 'Nissan GT-R',
            'categoria' => 'Group GT',
            'usuario_id' => 1,
        ),
        array(
            'marca' => 'Carrera',
            'modelo' => 'Lamborghini Huracán',
            'categoria' => 'Group GT',
            'usuario_id' => 1,
        ),
        array(
            'marca' => 'Fly',
            'modelo' => 'Mercedes AMG',
            'categoria' => 'Group GT',
            'usuario_id' => 1,
        ),
        array(
            'marca' => 'Slot.it',
            'modelo' => 'Toyota Supra',
            'categoria' => 'Group GT',
            'usuario_id' => 1,
        ),
        array(
            'marca' => 'Scalextric',
            'modelo' => 'Mazda MX-5',
            'categoria' => 'Group GT',
            'usuario_id' => 1,
        ),
        array(
            'marca' => 'Carrera',
            'modelo' => 'Honda NSX',
            'categoria' => 'Group GT',
            'usuario_id' => 1,
        ),
        array(
            'marca' => 'Ninco',
            'modelo' => 'Dodge Viper',
            'categoria' => 'Group GT',
            'usuario_id' => 1,
        ),
        array(
            'marca' => 'Fly',
            'modelo' => 'Ford GT',
            'categoria' => 'Group GT',
            'usuario_id' => 1,
        ),
        array(
            'marca' => 'Slot.it',
            'modelo' => 'McLaren P1',
            'categoria' => 'Group GT',
            'usuario_id' => 1,
        )
    );
    
}
