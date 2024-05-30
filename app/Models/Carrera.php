<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;
    protected $table='carreras';
    protected $fillable = ['nombre', 'vueltas', 'en_curso', 'slug', 'fecha', 'imagen_id', 'dispositivo_id', 'usuario_id'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function campeonatos()
    {
        return $this->belongsToMany(Campeonato::class, 'campeonato_carrera', 'carrera_id', 'campeonato_id');
    }

    public function participaciones()
    {
        return $this->hasMany(Participacion::class, 'id_carrera');
    }

    public function tiempos()
    {
        return $this->hasMany(Tiempo::class, 'carrera_id');
    }

    public function jugadores()
    {
        return $this->belongsToMany(Jugador::class, 'participaciones', 'id_carrera', 'id_jugador');
    }

    public function dispositivo()
    {
        return $this->belongsTo(Dispositivo::class, 'dispositivo_id');
    }

}
