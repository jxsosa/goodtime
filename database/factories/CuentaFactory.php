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
            'nombre' => $this->faker->randomElement(['banesco jhon',
            'banesco juridica',
            'Banesco kadrlyn',
            'banesco david',
            'banesco carlos',
            'banesco juan',
            'venezuela david',
            'venezuela johan',
            'venezuela kaderlyn',
            'banplus jurica'
            ])
        ];
    }
}
