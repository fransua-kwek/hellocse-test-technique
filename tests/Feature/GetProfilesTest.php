<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Domain\Administrator\Infrastructure\Database\Factories\AdministratorFactory;
use Src\Domain\Administrator\Infrastructure\Model\Administrator;
use Src\Domain\Profile\Domain\AccountStatusEnum;
use Src\Domain\Profile\Infrastructure\Database\Factories\ProfileFactory;
use Src\Domain\Profile\Infrastructure\Model\Profile;
use Tests\TestCase;
use Tymon\JWTAuth\JWT;

class GetProfilesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var array<Profile>
     */
    private array $profileList;

    protected function setUp(): void
    {
        parent::setUp();

        $profileListData = [
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
                'account_status' => AccountStatusEnum::Active
            ]),
            ProfileFactory::definition([
                'firstname' => 'firstname_profile_3',
                'lastname' => 'lastname_profile_3',
                'email' => 'profile-3@example.com',
                'account_status' => AccountStatusEnum::Active
            ]),
            ProfileFactory::definition([
                'firstname' => 'firstname_profile_4',
                'lastname' => 'lastname_profile_4',
                'email' => 'profile-4@example.com',
                'account_status' => AccountStatusEnum::Active
            ]),
            ProfileFactory::definition([
                'firstname' => 'firstname_profile_5',
                'lastname' => 'lastname_profile_5',
                'email' => 'profile-5@example.com',
                'account_status' => AccountStatusEnum::Active
            ]),

            ProfileFactory::definition([
                'firstname' => 'firstname_profile_6',
                'lastname' => 'lastname_profile_6',
                'email' => 'profile-6@example.com',
                'account_status' => AccountStatusEnum::WaitingApproval
            ]),
            ProfileFactory::definition([
                'firstname' => 'firstname_profile_7',
                'lastname' => 'lastname_profile_7',
                'email' => 'profile-7@example.com',
                'account_status' => AccountStatusEnum::Inactive
            ]),
        ];

        Profile::insert($profileListData);
    }

    public function test_can_retrieve_profiles_without_being_authenticated_on_page_2()
    {
        $response = $this->getJson('/api/profiles');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'items');
        $response->assertJsonStructure([
            'items' => [
                '*' => [
                    'id',
                    'firstname',
                    'lastname',
                    'email',
                    'image',
                    'created_at',
                    'updated_at',
                ],
            ],
            'total',
            'per_page',
            'current_page',
        ]);
    }

    public function test_can_retrieve_profiles_without_being_authenticated()
    {
        $response = $this->getJson('/api/profiles?page=2');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'items');
        $response->assertJsonStructure([
            'items' => [
                '*' => [
                    'id',
                    'firstname',
                    'lastname',
                    'email',
                    'image',
                    'created_at',
                    'updated_at',
                ],
            ],
            'total',
            'per_page',
            'current_page',
        ]);
    }

    public function test_can_retrieve_profiles_while_being_authenticated()
    {
        $admin = Administrator::create(AdministratorFactory::definition([
            'email' => 'test@example.com',
            'password' => 'password',
        ]));

        $token = app(JWT::class)->fromUser($admin);

        $response = $this->getJson('/api/profiles', [
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'items');
        $response->assertJsonStructure([
            'items' => [
                '*' => [
                    'id',
                    'firstname',
                    'lastname',
                    'email',
                    'image',
                    'created_at',
                    'updated_at',
                    'status',
                ],
            ],
            'total',
            'per_page',
            'current_page',
        ]);
    }
}
