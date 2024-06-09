<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    use HasFactory;
    protected $table='jugadores';
    protected $fillable = ['nombre','slug', 'imagen_id','equipo_id','coche_id'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function coche()
    {
        return $this->belongsTo(Coche::class);
    }

    public function participaciones()
    {
        return $this->hasMany(Participacion::class, 'id_jugador');
    }

    public function tiempos()
    {
        return $this->hasMany(Tiempo::class, 'jugador_id');
    }
    public function imagen(){
        return $this->hasOne(Imagen::class,'id','imagen_id');
    }

    
}
