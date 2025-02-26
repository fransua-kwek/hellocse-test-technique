<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Domain\Administrator\Infrastructure\Database\factories\AdministratorFactory;
use Src\Domain\Administrator\Infrastructure\Model\Administrator;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Administrator::create(AdministratorFactory::definition([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]));
    }
}
