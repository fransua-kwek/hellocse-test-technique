<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Src\Domain\Administrator\Infrastructure\Database\Factories\AdministratorFactory;
use Src\Domain\Administrator\Infrastructure\Model\Administrator;
use Src\Domain\Profile\Domain\AccountStatusEnum;
use Src\Domain\Profile\Infrastructure\Database\Factories\ProfileFactory;
use Src\Domain\Profile\Infrastructure\Model\Profile;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::transaction(function () {
            Administrator::create(AdministratorFactory::definition([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]));

            Profile::insert([
                ProfileFactory::definition([
                    'firstname' => 'firstname_profile_1',
                    'lastname' => 'lastname_profile_1',
                    'email' => 'profile-1@example.com',
                    'account_status' => AccountStatusEnum::Active
                ]),
                ProfileFactory::definition([
                    'firstname' => 'firstname_profile_2',
                    'lastname' => 'lastname_profile_2',
                    'email' => 'profile-2@example.com',
                    'account_status' => AccountStatusEnum::WaitingApproval
                ]),
                ProfileFactory::definition([
                    'firstname' => 'firstname_profile_3',
                    'lastname' => 'lastname_profile_3',
                    'email' => 'profile-3@example.com',
                    'account_status' => AccountStatusEnum::Inactive
                ]),
            ]);
        });
    }
}
