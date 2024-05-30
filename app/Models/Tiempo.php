<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiempo extends Model
{
    use HasFactory;

    protected $table='tiempos';
    protected $fillable = [
        'vuelta', 
        'tiempo', 
        'participacion_id', 
    ];

    public function participacion()
    {
        return $this->belongsTo(Participacion::class, 'participacion_id', 'id');
    }
}
