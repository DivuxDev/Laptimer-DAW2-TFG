<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participacion extends Model
{
    use HasFactory;

    protected $table='participaciones';
    protected $fillable = ['id_jugador', 'id_equipo', 'id_carrera','id_coche'];

/**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'id_carrera');
    }

    public function jugador()
    {
        return $this->belongsTo(Jugador::class, 'id_jugador');
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo');
    }

    public function coche()
    {
        return $this->belongsTo(Coche::class, 'id_coche');
    }
     /**
     * Relación con el modelo Tiempo.
     */
    public function tiempos()
    {
        return $this->hasMany(Tiempo::class, 'participacion_id');
    }
}
