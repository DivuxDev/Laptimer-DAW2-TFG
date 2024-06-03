<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Jugador;
use App\Models\Participacion;
use App\Models\Dispositivo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use PDOException;
use Exception;

class CarreraController extends Controller
{
  
    public function index()
    {
        // Obtener el usuario actualmente logueado
    $user = Auth::user();
    
    // Obtener las carreras basadas en los dispositivos del usuario logueado
    $carreras = $user->carreras();

    return view('carreras.index', ['carreras' => $carreras]);
    }

    public function show(Carrera $carrera)
    {
        return view('carreras.show', ['carrera' => $carrera]);
    }

    public function create()
    {
        $user = Auth::user();
        $jugadores = Jugador::where('usuario_id', $user->id)->get();
        $dispositivos = Dispositivo::where('usuario_id', $user->id)->get();
        return view('carreras.create', ['jugadores' => $jugadores,'dispositivos' => $dispositivos]);
    }

   /**
     * Recoge los datos de un Request y crean el objeto de tipo carrera que se el introduce por parametros
     * @param Request $request Request personalizado para crear la carrera
     * @return mixed Devuelve la vista en detalle de la carrera creada
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'vueltas' => 'required|integer|min:0|max:999',
            'fecha' => 'required|date',
            'dispositivo_id' => 'required',
        ]);
        try {
            //empiezo una transaccion por si al intentar crear la carrera falla algo poder volver atras
            DB::beginTransaction();
            
/* #region Crear la carrera */            
            // Si en_curso está marcado, actualiza todas las demás carreras a en_curso = false
            if ($request->has('en_curso')) {
                Carrera::where('en_curso', 1)->where('dispositivo_id',$request->dispositivo_id)->update(['en_curso' => 0]);
            }
            $carrera = new Carrera();
            $carrera->nombre = $request->nombre;
            $carrera->vueltas = $request->vueltas;
            $carrera->slug = Str::slug($request->nombre);
            $carrera->fecha = $request->fecha;
            $carrera->en_curso = $request->has('en_curso') ? 1 : 0;
            $carrera->dispositivo_id = $request->dispositivo_id;

            $carrera->save();
            // Obtener el ID de la carrera recién guardada
            $carreraId = $carrera->id;
/* #endregion */        
/* #region Crear la participacion */ 
            foreach($request->jugadores as $jugadorId){
                $participacion = new Participacion();
                $jugador = Jugador::where('id', $jugadorId)->firstOrFail();
                if ($jugador) {
                    $participacion->id_jugador = $jugador->id;
                    $participacion->id_carrera = $carreraId;
                    $participacion->id_coche = $jugador->coche->id; // Verificar si el jugador tiene un coche
                    $participacion->save();
                }
            }
/* #endregion */
            DB::commit();
            //si se crea correctamente redirigo a la pagina de la carrera con un mensaje de success
            return redirect()->route('carreras.show', ['carrera' => $carrera])->with('Success', 'Carrera creada');
        } catch (PDOException $e) {
            DB::rollBack();
            return redirect()->route('carreras.index')->with('error', 'Error de BD al crear la carrera. Detalles: ' . $e->getMessage());
        }
        catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('carreras.index')->with('error', 'Error general al crear la carrera. Detalles: ' . $e->getMessage());
        }
    }

    public function edit(Carrera $carrera)
    {

        $user = Auth::user();
        $jugadores = Jugador::where('usuario_id', $user->id)->get();
        $dispositivos = Dispositivo::where('usuario_id', $user->id)->get();
        
        // Obtener IDs de los jugadores que ya están participando en la carrera
        $jugadoresParticipantes = $carrera->participaciones->pluck('id_jugador')->toArray();

        return view('carreras.edit', [
            'carrera' => $carrera,
            'jugadores' => $jugadores,
            'dispositivos' => $dispositivos,
            'jugadoresParticipantes' => $jugadoresParticipantes
        ]);
    }

    public function update(Request $request, Carrera $carrera)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'vueltas' => 'required|integer|min:0|max:999',
            'fecha' => 'required|date',
            'dispositivo_id' => 'required|exists:dispositivos,id',
            'jugadores.*' => 'exists:jugadores,id',
        ]);

        try {
            // Empezamos una transacción
            DB::beginTransaction();

            // Actualizar los campos de la carrera
            $carrera->nombre = $request->nombre;
            $carrera->slug = Str::slug($request->nombre);
            $carrera->vueltas = $request->vueltas;
            $carrera->fecha = $request->fecha;
            $carrera->dispositivo_id = $request->dispositivo_id;
            $carrera->en_curso = $request->has('en_curso') ? 1 : 0;

            // Si en_curso está marcado, actualiza todas las demás carreras a en_curso = false
            if ($carrera->en_curso) {
                Carrera::where('en_curso', 1)->where('dispositivo_id',$request->dispositivo_id)->update(['en_curso' => 0]);
            }

            $carrera->save();

            // Actualizar participaciones
            $participacionesActuales = $carrera->participaciones->pluck('id')->toArray();
            $nuevasParticipaciones = $request->jugadores;

            $participacionesEliminar = array_diff($participacionesActuales, $nuevasParticipaciones);
            Participacion::whereIn('id', $participacionesEliminar)->delete();

             // Agregar las nuevas participaciones
            $participacionesAgregar = array_diff($nuevasParticipaciones, $participacionesActuales);
            foreach ($participacionesAgregar as $jugadorId) {
                $participacion = new Participacion();
                $jugador = Jugador::where('id', $jugadorId)->firstOrFail();
                $participacion->id_jugador = $jugadorId;
                $participacion->id_carrera = $carrera->id;
                $participacion->id_coche = $jugador->coche->id; 
                $participacion->save();
            }

            // Confirmamos la transacción
            DB::commit();

            return redirect()->route('carreras.index')->with('success', 'Carrera actualizada correctamente');
        } catch (PDOException $e) {
            // Si algo falla, hacemos rollback de la transacción
            DB::rollBack();

            return redirect()->route('carreras.index')->with('error', 'Error al actualizar la carrera. Detalles: ' . $e->getMessage());
        }
    }

    public function destroy(Carrera $carrera)
    {
        try {
            $carrera->delete();
        } catch (PDOException $e) {
            return redirect()->route('carreras.index')->with('error', 'Error de base de datos al borrar la carrera ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->route('carreras.index')->with('error', 'Error al borrar la carrera ' . $e->getMessage());
        }
        return redirect()->route('carreras.index')->with('success', 'Carrera borrado');
    }

}
