<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispositivo extends Model
{
    use HasFactory;
    protected $table='dispositivos';
    protected $fillable = [
        'nombre', 'mac','slug', 'usuario_id'
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
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function carreras()
    {
        return $this->hasMany(Carrera::class,'dispositivo_id');
    }
}
