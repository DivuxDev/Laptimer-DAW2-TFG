<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;
    protected $table='equipos';
    protected $fillable = [
        'nombre', 'descripcion', 'slug', 'imagen_id','usuario_id'
    ];
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function jugadores()
    {
        return $this->hasMany(Jugador::class, 'equipo_id');
    }

    public function participaciones()
    {
        return $this->hasMany(Participacion::class, 'id_equipo');
    }
}
