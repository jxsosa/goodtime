<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $name=$this->faker->name();
        return [
            //
            'nombre' => $name,
            'email' => $this->faker->unique()->safeEmail(),
            'direccion' =>$this->faker->text(200),
            'telefono' =>$this->faker->unique()->randomNumber(9, true),
            'user_id'=> User::all()->random()->id
        ];
    }
}
