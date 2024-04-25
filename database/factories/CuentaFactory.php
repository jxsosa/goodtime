<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cuenta>
 */
class CuentaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nombre' => $this->faker->randomElement([
                'EFECTIVO',
                'USDT',
            'BANESCO JHONATHAN',
            'BANESCO TEREBELL',
            'BANESCO KADERLYN',
            'BANESCO DAVID',
            'BANESCO JOHAN',
            'BANESCO REBECA',
            'VENEZUELA DAVID',
            'VENEZUELA JOHAN',
            'VENEZUELA KADERLYN',
            'VENEZUELA JHONATHAN',
            'VENEZUELA VARGAS2015',
            'BANPLUS DAVID',
            'BANPLUS JOHAN',
            'BANPLUS KADERLYN',
            'BANPLUS JHONATHAN',
            'BANPLUS VARGAS2015'
            ])
        ];
    }
}
