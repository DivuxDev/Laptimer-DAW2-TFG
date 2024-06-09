<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Jugador;

class Coche extends Model
{
    use HasFactory;
    protected $table='coches';
    protected $fillable = [
        'modelo','marca','categoria', 'slug', 'imagen_id', 'usuario_id'
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

    public function imagen(){
        return $this->hasOne(Imagen::class,'id','imagen_id');
    }

/**
     * The players associated with the car.
     */
    public function jugadores()
    {
        return $this->hasMany(Jugador::class, 'coche_id');
    }
    
    public function participaciones()
    {
        return $this->hasMany(Participacion::class);
    }
}
