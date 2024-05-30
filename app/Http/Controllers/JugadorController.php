<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jugador;
use App\Models\Equipo;
use PDOException;
use Exception; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JugadorController extends Controller
{
    public function index()
    {
    // Obtener el usuario actualmente logueado
    $user = Auth::user();
    
    $jugadores = $user->jugadores;
    return view('jugadores.index', ['jugadores' => $jugadores]);
    }

    public function show(Jugador $jugador)
    {
        return view('jugadores.show', ['jugador' => $jugador]);
    }

    public function edit(Jugador $jugador)
    {
        // Obtener el usuario actualmente logueado
        $user = Auth::user();
        $equipos = $user->equipos;
        $coches = $user->coches;
        return view('jugadores.edit', ['jugador' => $jugador,'equipos' => $equipos,'coches' => $coches]);
    }

    public function create()
    {
        // Obtener el usuario actualmente logueado
        $user = Auth::user();
        $equipos = $user->equipos;
        $coches = $user->coches;
        return view('jugadores.create',['equipos' => $equipos,'coches' => $coches]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jugador  $jugador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jugador $jugador)
    {
        try {
        // Validación de los datos entrantes
        $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha' => 'required|date',
            'equipos' => 'nullable|exists:equipos,id',
            'imagen_id' => 'nullable|exists:imagenes,id',
            'coches' => 'required',
        ]);

        // Actualización de los datos del jugador
        
            $jugador->nombre = $request->input('nombre');
            $jugador->fecha = $request->input('fecha');
            $jugador->equipo_id = $request->input('equipos');
            $jugador->coche_id = $request->input('coches');
            $jugador->save();
        
    
        // Redirección con un mensaje de éxito
        return redirect()->route('jugadores.show', $jugador->slug)->with('success', 'Se ha editado correctamente el jugador');
        } catch (PDOException $e) {
            // Redirigir a la página anterior con un mensaje de error
            return redirect()->route('jugadores.index')->with('error', 'Error de base de datos al editar el jugador. Detalles: ' . $e->getMessage());
        }catch (Exception $e) {
            return redirect()->route('jugadores.index')->with('error', 'Error de general al editar el jugador ' . $e->getMessage());
        }
    }

    /**
     * Recoge los datos de un Request y crean el objeto de tipo jugador que se el introduce por parametros
     * @param Request $request Request personalizado para crear el jugador
     * @return mixed Devuelve la vista en detalle del jugador creado
     */
    public function store(Request $request)
    {
        
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:60',
            'fecha' => 'required|date',
            'equipos' => 'required',
            'coches' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // Crear un nuevo jugador
            $jugador = new Jugador();
            $jugador->nombre = $request->nombre;
            $jugador->slug = Str::slug($request->nombre);
            $jugador->fecha = $request->fecha;
            //guardo el ID del equipo seleccionado
            if($request->has('equipos')){
                $jugador->equipo_id = $request->equipos;
            }
            //guardo el ID del coche seleccionado
            if($request->has('coches')){
                $jugador->coche_id = $request->coches;
            }

            $jugador->usuario_id = auth()->id();
            $jugador->save();
             DB::commit();
            // Redirigir a la vista de detalle del jugador con un mensaje de éxito
            return redirect()->route('jugadores.show', ['jugador' => $jugador])->with('success', 'Jugador creado exitosamente');
        } catch (PDOException $e) {
            DB::rollBack();

            // Redirigir a la página anterior con un mensaje de error
            return redirect()->route('jugadores.index')->with('error', 'Error de BD al crear el jugador. Detalles: ' . $e->getMessage());
        }catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('jugadores.index')->with('error', 'Error general al crear el jugador ' . $e->getMessage());
        }
    }

    public function destroy(Jugador $jugador)
    {
        try {
            $jugador->delete();
        } catch (PDOException $e) {
            return redirect()->route('jugadores.index')->with('error', 'Error de base de datos al borrar el jugador ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->route('jugadores.index')->with('error', 'Error al borrar el jugador ' . $e->getMessage());
        }
        return redirect()->route('jugadores.index')->with('success', 'Jugador borrado');
    }
}
