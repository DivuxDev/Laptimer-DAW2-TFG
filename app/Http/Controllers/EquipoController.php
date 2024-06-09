<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDOException;
use Exception; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
Use App\Models\Equipo;
Use App\Models\Jugador;
use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;

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
        $user = Auth::user();
        $miembros = $user->jugadores;
        return view('equipos.edit',['equipo'=>$equipo,'miembros' => $miembros]);
    }

    public function create()
    { 
        $user = Auth::user();
        $miembros = $user->jugadores;
        return view('equipos.create',['miembros' => $miembros]);
    }


    public function update(Request $request, Equipo $equipo)
    {
        // Validación de los datos entrantes
        $request->validate([
            'nombre' => 'required|string|max:66',
            'descripcion' => 'required|string|max:255',
            'imagen' =>  'mimes:jpg,png',
        ], [
            'imagen.mimes' => 'La imagen debe ser un archivo de tipo: jpg, png.',
            'imagen.max' => 'La imagen no debe exceder los 2MB.',
        ]
        );
    
        try {
            DB::beginTransaction();
    
            // Actualizar los datos del equipo
            $equipo->nombre = $request->input('nombre');
            $equipo->descripcion = $request->input('descripcion');
            $equipo->slug = Str::slug($equipo->nombre);
            
            if($request->hasFile('imagen')){
                if($equipo->imagen != null){

                    // Elimina la imagen anterior
                    Storage::disk('public')->delete($equipo->imagen->url);

                    $nombreArchivo = time() . '.' . $request->imagen->extension();
                    $ruta = $request->imagen->storeAs('imagenes', $nombreArchivo, 'public');

                    $equipo->imagen->url = $ruta;
                    $equipo->imagen->save();
                }else{
                    if($request->has('imagen')){
                        $nombreArchivo = time() . '.' . $request->imagen->extension();
                        $ruta = $request->imagen->storeAs('imagenes', $nombreArchivo, 'public');
                
                        $imagen = new Imagen();
                        $imagen->url = $ruta;
                        $imagen->save();
                        
                        $equipo->imagen_id=$imagen->id;
                    }
                }
            }
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
            'imagen' =>  'mimes:jpg,png',
        ], [
            'imagen.mimes' => 'La imagen debe ser un archivo de tipo: jpg, png.',
            'imagen.max' => 'La imagen no debe exceder los 2MB.',
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

            if($request->has('imagen')){
                $nombreArchivo = time() . '.' . $request->imagen->extension();
                $ruta = $request->imagen->storeAs('imagenes', $nombreArchivo, 'public');
        
                $imagen = new Imagen();
                $imagen->url = $ruta;
                $imagen->save();
                
                $equipo->imagen_id=$imagen->id;
            }
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
