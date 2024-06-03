<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDOException;
use Exception; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
Use App\Models\Equipo;

class EquipoController extends Controller
{
    public function index()
    {
    // Obtener el usuario actualmente logueado
    $user = Auth::user();
    $equipos = $user->equipos;
    return view('equipos.index', ['equipos' => $equipos]);
    }

    public function show(Equipo $equipo)
    {
        return view('equipos.show', ['equipo' => $equipo]);
    }

    public function edit(Equipo $equipo)
    {
        return view('equipos.edit',['equipo' => $equipo]);
    }

    public function create()
    { 
        $user = Auth::user();

        $jugadores = $user->jugadores;
        return view('equipos.create',['jugadores' => $jugadores]);
    }


    public function update(Request $request, Equipo $equipo)
    {
        try {
        // Validación de los datos entrantes
        $request->validate([
            'nombre' => 'required|string|max:66',
            'descripcion' => 'required|string|max:255',
            'imagen_id' => 'nullable|exists:imagenes,id',
        ]);

        $equipo->nombre = $request->input('nombre');
        $equipo->descripcion = $request->input('descripcion');
        $equipo->slug = Str::slug($equipo->nombre);
        //$equipo->imagen_id = $request->input('imagen_id');

        $equipo->save();

        // Redirección con un mensaje de éxito
        return redirect()->route('equipos.show', $equipo->slug)->with('success', 'equipo actualizado correctamente.');
        } catch (PDOException $e) {
            // Redirigir a la página anterior con un mensaje de error
            return redirect()->route('equipos.index')->with('error', 'Error de base de datos al editar el equipo. Detalles: ' . $e->getMessage());
        }catch (Exception $e) {
            return redirect()->route('equipos.index')->with('error', 'Error de general al editar el equipo ' . $e->getMessage());
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
