<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cambio;
use App\Models\Cliente;
use App\Models\Cuenta;
use App\Models\Movimiento;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(UserSeeder::class);
        Cambio::factory(6)->create();
        Cuenta::factory(10)->create();
        Cliente::factory(50)->create();
        Movimiento::factory(100)->create();
    }
}
