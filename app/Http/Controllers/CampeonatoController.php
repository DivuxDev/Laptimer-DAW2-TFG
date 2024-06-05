<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Dispositivo;
use App\Models\Campeonato;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use PDOException;
use Exception;

class CampeonatoController extends Controller
{
    public function index()
    {
    // Obtener el usuario actualmente logueado
    $user = Auth::user();
    $campeonatos = $user->campeonatos;
    return view('campeonatos.index', ['campeonatos' => $campeonatos]);
    }

    public function show(Campeonato $campeonato)
    {
        return view('campeonatos.show', ['campeonato' => $campeonato]);
    }

    public function edit(campeonato $campeonato)
    {
        $user = Auth::user();
        $carreras = $user->carreras;
        return view('campeonatos.edit',['campeonato'=>$campeonato,'carreras' => $carreras]);
    }

    public function create()
    { 
        $user = Auth::user();
        $carreras = $user->carreras;
        return view('campeonatos.create',['carreras' => $carreras]);
    }


    public function update(Request $request, Equipo $equipo)
    {
        // Validación de los datos entrantes
        $request->validate([
            'nombre' => 'required|string|max:66',
            'descripcion' => 'required|string|max:255',
        ]);
    
        try {
            DB::beginTransaction();
    
            // Actualizar los datos del equipo
            $equipo->nombre = $request->input('nombre');
            $equipo->descripcion = $request->input('descripcion');
            $equipo->slug = Str::slug($equipo->nombre);
            $equipo->save();
    
            // Actualizar el equipo_id de cada jugador seleccionado
            // Primero, desasociar todos los jugadores del equipo actual
            Jugador::where('equipo_id', $equipo->id)->update(['equipo_id' => null]);
    
            // Luego, asociar los jugadores seleccionados al equipo
            $jugadoresIds = $request->input('miembros');
            foreach ($jugadoresIds as $jugadorId) {
                $jugador = Jugador::find($jugadorId);
                $jugador->equipo_id = $equipo->id;
                $jugador->save();
            }
    
            DB::commit();
    
            // Redirección con un mensaje de éxito
            return redirect()->route('equipos.show', $equipo->slug)->with('success', 'Equipo actualizado correctamente.');
        } catch (PDOException $e) {
            DB::rollBack();
            // Redirigir a la página anterior con un mensaje de error
            return redirect()->route('equipos.index')->with('error', 'Error de base de datos al editar el equipo. Detalles: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            // Redirigir a la página anterior con un mensaje de error
            return redirect()->route('equipos.index')->with('error', 'Error general al editar el equipo. Detalles: ' . $e->getMessage());
        }
    }
    

    /**
     * Recoge los datos de un Request y crean el objeto de tipo coche que se el introduce por parametros
     * @param Request $request Request personalizado para coche la carrera
     * @return mixed Devuelve la vista en detalle del coche creado
     */
    public function store(Request $request)
    {
        
        // Validación de los datos entrantes
        $request->validate([
            'nombre' => 'required|string|max:66',
            'descripcion' => 'required|string|max:255',
            'imagen_id' => 'nullable|exists:imagenes,id',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            // Crear un nuevo coche
            $equipo = new Equipo();
            $equipo->nombre = $request->input('nombre');
            $equipo->descripcion = $request->input('descripcion');
            
            $equipo->slug = Str::slug($equipo->nombre);
            $equipo->usuario_id = auth()->id();
            $equipo->save();


            if($request->has('miembros')){
                $jugadoresIds = $request->input('miembros');
                foreach ($jugadoresIds as $jugadorId) {
                    $jugador = Jugador::find($jugadorId);
                    $jugador->equipo_id = $equipo->id;
                    $jugador->save();
                }
            }
             
            DB::commit();

            // Redirigir a la vista de detalle del coche con un mensaje de éxito
            return redirect()->route('equipos.show', ['equipo' => $equipo])->with('success', 'equipo creado exitosamente');
        } catch (PDOException $e) {
            DB::rollBack();
            // Redirigir a la página anterior con un mensaje de error
            return redirect()->route('equipos.index')->with('error', 'Error al crear el equipo. Detalles: ' . $e->getMessage());
        }catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('equipos.index')->with('error', 'Error de general al editar el equipo ' . $e->getMessage());
        }
    }

    public function destroy(Equipo $equipo)
    {
        try {
            $equipo->delete();
        } catch (PDOException $e) {
            return redirect()->route('equipos.index')->with('error', 'Error de base de datos al borrar el equipo ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->route('equipos.index')->with('error', 'Error al borrar el equipo ' . $e->getMessage());
        }
        return redirect()->route('equipos.index')->with('success', 'equipo borrado');
    }
}

