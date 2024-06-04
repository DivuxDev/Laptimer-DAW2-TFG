<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Carrera;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
    protected $table = "usuarios";
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Define the relationship between User and Jugador.
     */
    public function jugadores()
    {
        return $this->hasMany(Jugador::class,'usuario_id');
    }

    /**
     * Define the relationship between User and Coche.
     */
    public function coches()
    {
        return $this->hasMany(Coche::class,'usuario_id');
    }

    /**
     * Define the relationship between User and Jugador.
     */
    public function equipos()
    {
        return $this->hasMany(Equipo::class,'usuario_id');
    }

    /**
     * Define the relationship between User and Dispositivo.
     */
    public function dispositivos()
    {
        return $this->hasMany(Dispositivo::class,'usuario_id');
    }

    public function carreras(){
       return Carrera::join('dispositivos', 'carreras.dispositivo_id', '=', 'dispositivos.id')
                        ->where('dispositivos.usuario_id',auth()->user()->id)
                        ->select('carreras.*')
                        ->get();
    }

    public function carrerasQuery(){
        return Carrera::join('dispositivos', 'carreras.dispositivo_id', '=', 'dispositivos.id')
        ->where('dispositivos.usuario_id', $this->id)
        ->select('carreras.id', 'carreras.nombre', 'carreras.fecha', 'carreras.dispositivo_id');

     }
}
