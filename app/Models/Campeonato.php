<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campeonato extends Model
{
    use HasFactory;
    protected $table='campeonatos';
    protected $fillable = ['nombre', 'fecha', 'en_curso', 'slug', 'imagen_id'];
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function carreras()
    {
        return $this->belongsToMany(Carrera::class, 'campeonato_carrera', 'campeonato_id', 'carrera_id');
    }

    public function imagen(){
        return $this->hasOne(Imagen::class,'id','imagen_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
