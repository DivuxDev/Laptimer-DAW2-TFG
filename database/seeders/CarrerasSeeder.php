<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Carrera;
use Illuminate\Support\Str;
class CarrerasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Recorrer array de aulas
        foreach ($this->carreras as $carrera) {
            //Creacion del modelo de carrera para rellenar la base de datos
            $carreraObj = new Carrera();
            $carreraObj->nombre = $carrera['nombre'];
            $carreraObj->slug = Str::slug($carreraObj->nombre);
            $carreraObj->vueltas = $carrera['vueltas'];
            $carreraObj->en_curso = $carrera['en_curso'];
            $carreraObj->fecha = $carrera['fecha'];
            $carreraObj->dispositivo_id = 1;

            //Guardar el objeto en la base de datos
            $carreraObj->save();
        }

        //Creacion del modelo de carrera para rellenar la base de datos
        $carreraObj = new Carrera();
        $carreraObj->nombre = 'carrera segundo dispositivo';
        $carreraObj->slug = Str::slug($carreraObj->nombre);
        $carreraObj->vueltas = 5;
        $carreraObj->en_curso = true;
        $carreraObj->fecha = '2024/03/11';
        $carreraObj->dispositivo_id = 2;

        //Guardar el objeto en la base de datos
        $carreraObj->save();
        
    }

    private $carreras = array(
        array(
            'nombre' => 'Carrrera de prueba 1',
            'vueltas' => 6,
            'en_curso' => true,
            'fecha' => '2024/03/11'
        ),
        array(
            'nombre' => 'Carrrera de prueba 2',
            'vueltas' => 4,
            'en_curso' => false,
            'fecha' => '2024/03/22'
        ),
        array(
            'nombre' => 'Carrrera de prueba 3',
            'vueltas' => 7,
            'en_curso' => false,
            'fecha' => '2024/03/24'
        ),
        array(
            'nombre' => 'Rally Monte Carlo',
            'vueltas' => 5,
            'en_curso' => false,
            'fecha' => '2024/04/05'
        ),
        array(
            'nombre' => 'Rally Argentina',
            'vueltas' => 8,
            'en_curso' => false,
            'fecha' => '2024/04/12'
        ),
        array(
            'nombre' => 'Rally Finland',
            'vueltas' => 9,
            'en_curso' => false,
            'fecha' => '2024/04/19'
        ),
        array(
            'nombre' => 'Rally Deutschland',
            'vueltas' => 3,
            'en_curso' => false,
            'fecha' => '2024/05/02'
        ),
        array(
            'nombre' => 'Rally Acropolis',
            'vueltas' => 6,
            'en_curso' => false,
            'fecha' => '2024/05/11'
        ),
        array(
            'nombre' => 'Rally Australia',
            'vueltas' => 10,
            'en_curso' => false,
            'fecha' => '2024/05/20'
        ),
        array(
            'nombre' => 'Rally Sweden',
            'vueltas' => 4,
            'en_curso' => false,
            'fecha' => '2024/05/28'
        )
    );
    
}
