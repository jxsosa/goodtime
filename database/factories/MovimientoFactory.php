<?php

namespace Database\Factories;

use App\Models\Cambio;
use App\Models\Cliente;
use App\Models\Cuenta;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movimiento>
 */
class MovimientoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bs=$this->faker->randomFloat(2, 10, 50000);
        $tasa=$this->faker->randomFloat(2, 37, 40);
        return [
            //
            'bs'=>$bs,
            'tasa' =>$tasa,
            'monto'=>$bs/$tasa,
            'ref' =>$this->faker->randomNumber(6, true),
            'descripcion' =>$this->faker->text(200),
            'tipo'=>$this->faker->randomElement(['entrada','salida']),
            //'cuenta'=>$this->faker->randomElement(['cobrar','pagar']),
            'fecha_entrega'=>$this->faker->date(),
            'user_id' => User::all()->random()->id,
            'cambio_id' => Cambio::all()->random()->id,
            'cuenta_id' => Cuenta::all()->random()->id,
            'cliente_id' => Cliente::all()->random()->id

        ];
    }
}
