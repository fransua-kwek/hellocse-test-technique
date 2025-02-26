<?php

namespace Src\Domain\Administrator\Infrastructure\Database\Factories;

use Illuminate\Support\Facades\Hash;

class AdministratorFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public static function definition(array $data): array
    {
        return [
            'name' => $data['name'] ?? fake()->name(),
            'email' => $data['email'] ?? fake()->unique()->safeEmail(),
            'password' => $data['password'] ?? Hash::make('password'),
        ];
    }
}
