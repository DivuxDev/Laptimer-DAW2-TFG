<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dispositivo;
use Illuminate\Support\Facades\Auth;

class DispositivoController extends Controller
{

    public function index()
    {
        $dispositivos = Auth::user()->dispositivos;
        return view('dispositivos.index',['dispositivos' => $dispositivos]);
    
    }
}
