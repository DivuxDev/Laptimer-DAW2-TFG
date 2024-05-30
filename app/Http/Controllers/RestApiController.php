<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Participacion;
use App\Models\Dispositivo;
use App\Models\Tiempo;

class RestApiController extends Controller
{

    /**
     * Recibe un SLUG de un dispositivo y devuelve los datos del a carrera en curso
     * @param Dispositivo $dispositivo Slug que es la mac slugificada de la raspberry
     * @return mixed Devuelve o el objeto json de la carrera o un codigo de error
     */
    public function carrera(Dispositivo $dispositivo)
    {
        $carrera = Carrera::where('dispositivo_id', $dispositivo->id)->where('en_curso', true)->first();
        if (!$carrera) {
            return response()->json(['error' => 'carrera no encontrada'], 404);
        }
        return response()->json($carrera);
    }

    /**
     * Recibe un request que contiene los datos de vuelta,
     * tiempo e id de participacion de un jugador en una carrera y lo inserta en la tabla tiempos
     * @param Request $request Datos del objeto tiempo
     * @return mixed Devuelve o un codigo correcto o incorrecto
     */
    public function insertarTiempo(Request $request)
    {
        
        // Validar la solicitud
        $validated = $request->validate([
            'vuelta' => 'required|integer',
            'tiempo' => 'required|numeric',
            'participacion_id' => 'required',
        ]);

        // Crear un nuevo registro de tiempo
        $tiempo = new Tiempo();
        $tiempo->vuelta= $request->vuelta;
        $tiempo->participacion_id =  $request->participacion_id;
        $tiempo->tiempo =  $request->tiempo;
        $tiempo->save();

        // Devolver una respuesta JSON
        return response()->json([
            'message' => 'Tiempo insertado correctamente',
            'data' => $tiempo
        ], 201);
    
    }

    /**
     * Recibe un request que contiene los de un jugador y una carrera para devolver
     * el ID de participacion de ese jugador
     * @param Request $request id de jugador e id de carrera
     * @return mixed Devuelve o los datos de la participacion o un codigo incorrecto
     */
    public function getParticipacion(Request $request)
    {
        $request->validate([
            'id_carrera' => 'required|integer',
            'id_jugador' => 'required|integer',
        ]);

        $participacion = Participacion::where('id_carrera', $request->id_carrera)
            ->where('id_jugador', $request->id_jugador)
            ->with('tiempos')
            ->first();

        if (!$participacion) {
            return response()->json(['error' => 'Participacion no encontrada'], 404);
        }

        return response()->json($participacion);
    }

}
