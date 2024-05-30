<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Coche;
use App\Models\Equipo;
use PDOException;
use Exception; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CocheController extends Controller
{
    public function index()
    {
    // Obtener el usuario actualmente logueado
    $user = Auth::user();
    $coches = $user->coches;
    return view('coches.index', ['coches' => $coches]);
    }

    public function show(Coche $coche)
    {
        return view('coches.show', ['coche' => $coche]);
    }

    public function edit(Coche $coche)
    {
        return view('coches.edit',['coche' => $coche]);
    }

    public function create()
    { 
        return view('coches.create');
    }


    public function update(Request $request, Coche $coche)
    {
        try {
        // Validación de los datos entrantes
        $request->validate([
            'modelo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'imagen_id' => 'nullable|exists:imagenes,id',
        ]);

        $coche->modelo = $request->input('modelo');
        $coche->marca = $request->input('marca');
        $coche->categoria = $request->input('categoria');
        $coche->slug = Str::slug($coche->modelo);
        //$coche->imagen_id = $request->input('imagen_id');
        $coche->save();
        // Redirección con un mensaje de éxito
        return redirect()->route('coches.show', $coche->slug)->with('success', 'coche actualizado correctamente.');
        } catch (PDOException $e) {
            // Redirigir a la página anterior con un mensaje de error
            return redirect()->route('coches.index')->with('error', 'Error de base de datos al editar el coche. Detalles: ' . $e->getMessage());
        }catch (Exception $e) {
            return redirect()->route('coches.index')->with('error', 'Error de general al editar el coche ' . $e->getMessage());
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
            'modelo' => 'required|string|max:60',
            'marca' => 'required|string|max:60',
            'categoria' => 'required|string|max:60',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            // Crear un nuevo coche
            $coche = new Coche();
            $coche->modelo = $request->input('modelo');
            $coche->marca = $request->input('marca');
            $coche->categoria = $request->input('categoria');
            $coche->slug = Str::slug($coche->modelo);
            $coche->usuario_id = auth()->id();
            $coche->save();
            DB::commit();

            // Redirigir a la vista de detalle del coche con un mensaje de éxito
            return redirect()->route('coches.show', ['coche' => $coche])->with('success', 'coche creado exitosamente');
        } catch (PDOException $e) {
            DB::rollBack();
            // Redirigir a la página anterior con un mensaje de error
            return redirect()->route('coches.index')->with('error', 'Error al crear el coche. Detalles: ' . $e->getMessage());
        }catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('coches.index')->with('error', 'Error de general al editar el coche ' . $e->getMessage());
        }
    }

    public function destroy(Coche $coche)
    {
        try {
            $coche->delete();
        } catch (PDOException $e) {
            return redirect()->route('coches.index')->with('error', 'Error de base de datos al borrar el coche ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->route('coches.index')->with('error', 'Error al borrar el coche ' . $e->getMessage());
        }
        return redirect()->route('coches.index')->with('success', 'coche borrado');
    }
}
