<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'alamat' => $this->faker->address(),
            'no_hp' => $this->faker->numerify('08##########'),
            'role' => 'user',
            'tanggal_daftar' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
