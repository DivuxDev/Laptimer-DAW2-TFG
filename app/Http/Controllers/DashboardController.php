<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jugador;
use App\Models\Carrera;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $proximasCarreras = $user->carrerasQuery()->orderBy('fecha', 'asc')->take(5)->get();
        $ultimosJugadores = Jugador::where('usuario_id', $user->id)->orderBy('created_at', 'desc')->take(5)->get();
        $ultimasCarreras = $user->carrerasQuery()->orderBy('fecha', 'desc')->take(5)->get();
        $carreras = $user->carrerasQuery()->select('carreras.nombre as title', 'carreras.fecha as start')->get();
        return view('laptimer.dashboard', compact('ultimosJugadores', 'ultimasCarreras', 'proximasCarreras', 'carreras'));
    
    }
}