<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Jugador;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jugador>
 */
class JugadorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Jugador::class;

    public function definition(): array
    {
        $nombre = $this->faker->name;
        return [
            'nombre' => $nombre,
            'fecha' => $this->faker->date,
            'slug' => Str::slug($nombre),
            'usuario_id' => 1,
            'equipo_id' => 1,
            'coche_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
