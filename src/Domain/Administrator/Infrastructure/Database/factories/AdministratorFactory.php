<?php

namespace Src\Domain\Administrator\Infrastructure\Database\factories;

use Illuminate\Support\Facades\Hash;

class AdministratorFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    static public function definition(array $data): array
    {
        return [
            'name' => $data['name'] ?? fake()->name(),
            'email' => $data['email'] ?? fake()->unique()->safeEmail(),
            'password' => $data['password'] ?? Hash::make('password'),
        ];
    }
}
