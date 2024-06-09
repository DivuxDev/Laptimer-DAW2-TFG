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
use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;

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
        $carreras = $user->carreras();
        $carrerasSeleccionadas = $campeonato->carreras()->pluck('carrera_id')->toArray();

        return view('campeonatos.edit',['campeonato'=>$campeonato,'carreras' => $carreras,'carrerasSeleccionadas' => $carrerasSeleccionadas]);
    }

    public function create()
    { 
        $user = Auth::user();
        $carreras = $user->carreras();
        return view('campeonatos.create',['carreras' => $carreras]);
    }

    
    /**
     * Recoge los datos de un Request y crean el objeto de tipo campeonato que se el introduce por parametros
     * @param Request $request Request personalizado para el campeonato
     * @return mixed Devuelve la vista en detalle del campeonato creado
     */
    public function store(Request $request)
    {
        // Validación de los datos entrantes
        $request->validate([
            'nombre' => 'required|string|max:66',
            'descripcion' => 'required|string|max:255',
            'fecha' => 'required|date',
            'carreras' => 'nullable|array',
            'carreras.*' => 'exists:carreras,id',
            'imagen' =>  'mimes:jpg,png',
        ], [
            'imagen.mimes' => 'La imagen debe ser un archivo de tipo: jpg, png.',
            'imagen.max' => 'La imagen no debe exceder los 2MB.',
        ]);
        try {
            DB::beginTransaction();

            $user = Auth::user();
            // Crear un nuevo campeonato
            $campeonato = new Campeonato();
            $campeonato->nombre = $request->input('nombre');  
            $campeonato->descripcion = $request->input('descripcion');               
            $campeonato->slug = Str::slug($campeonato->nombre);
            $campeonato->fecha = $request->input('fecha');
            $campeonato->usuario_id = auth()->id();
           
            if($request->has('imagen')){
                $nombreArchivo = time() . '.' . $request->imagen->extension();
                $ruta = $request->imagen->storeAs('imagenes', $nombreArchivo, 'public');

                $imagen = new Imagen();
                $imagen->url = $ruta;
                $imagen->save();
                
                $campeonato->imagen_id=$imagen->id;
            }
            $campeonato->save();
            // Asociar carreras al campeonato
            if ($request->has('carreras')) {
                $carrerasIds = $request->input('carreras');
                foreach ($carrerasIds as $carreraId) {
                    DB::table('campeonato_carrera')->insert([
                        'campeonato_id' => $campeonato->id,
                        'carrera_id' => $carreraId,
                    ]);
                }
            }
            DB::commit();
            // Redirigir a la vista de detalle del campeonat con un mensaje de éxito
            return redirect()->route('campeonatos.show', ['campeonato' => $campeonato])->with('success', 'campeonato creado exitosamente');
        } catch (PDOException $e) {
            DB::rollBack();
            // Redirigir a la página anterior con un mensaje de error
            return redirect()->route('carreras.list')->with('error', 'Error al crear el campeonato. Detalles: ' . $e->getMessage());
        }catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('carreras.list')->with('error', 'Error de general al crear el campeonato ' . $e->getMessage());
        }
    }
    public function update(Request $request, Campeonato $campeonato)
    {
        // Validación de los datos entrantes
        $request->validate([
            'nombre' => 'required|string|max:66',
            'descripcion' => 'required|string|max:255',
            'fecha' => 'required|date',
            'carreras' => 'nullable|array',
            'carreras.*' => 'exists:carreras,id',
            'imagen' =>  'mimes:jpg,png',
        ], [
            'imagen.mimes' => 'La imagen debe ser un archivo de tipo: jpg, png.',
            'imagen.max' => 'La imagen no debe exceder los 2MB.',
        ]);

        try {
            DB::beginTransaction();

            // Actualizar los datos del campeonato
            $campeonato->nombre = $request->input('nombre');
            $campeonato->descripcion = $request->input('descripcion');               
            $campeonato->fecha = $request->input('fecha');
            $campeonato->slug = Str::slug($campeonato->nombre);
            if($request->hasFile('imagen')){
                if($campeonato->imagen != null){

                    // Elimina la imagen anterior
                    Storage::disk('public')->delete($campeonato->imagen->url);
    
                    $nombreArchivo = time() . '.' . $request->imagen->extension();
                    $ruta = $request->imagen->storeAs('imagenes', $nombreArchivo, 'public');
            
                    $campeonato->imagen->url = $ruta;
                    $campeonato->imagen->save();
                }else{
                    if($request->has('imagen')){
                        $nombreArchivo = time() . '.' . $request->imagen->extension();
                        $ruta = $request->imagen->storeAs('imagenes', $nombreArchivo, 'public');
                
                        $imagen = new Imagen();
                        $imagen->url = $ruta;
                        $imagen->save();
                        
                        $campeonato->imagen_id=$imagen->id;
                    }
                }
            }
            $campeonato->save();

            // Actualizar las carreras asociadas al campeonato
            $carrerasIds = $request->input('carreras');
            DB::table('campeonato_carrera')->where('campeonato_id', $campeonato->id)->delete();
            if (!empty($carrerasIds)) {
                foreach ($carrerasIds as $carreraId) {
                    DB::table('campeonato_carrera')->insert([
                        'campeonato_id' => $campeonato->id,
                        'carrera_id' => $carreraId,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('campeonatos.show', $campeonato)->with('success', 'Campeonato actualizado correctamente.');
        } catch (PDOException $e) {
            DB::rollBack();
            return redirect()->route('carreras.list')->with('error', 'Error de base de datos al actualizar el campeonato. Detalles: ' . $e->getMessage());
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('carreras.list')->with('error', 'Error general al actualizar el campeonato. Detalles: ' . $e->getMessage());
        }
    }
    


    public function destroy(Campeonato $campeonato)
    {
        try {
            $campeonato->delete();
        } catch (PDOException $e) {
            return redirect()->route('carreras.list')->with('error', 'Error de base de datos al borrar el campeonato ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->route('carreras.list')->with('error', 'Error al borrar el campeonato ' . $e->getMessage());
        }
        return redirect()->route('carreras.list')->with('success', 'Campeonato borrado');
    }
}

