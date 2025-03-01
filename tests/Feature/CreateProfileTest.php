<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Src\Domain\Administrator\Infrastructure\Database\Factories\AdministratorFactory;
use Src\Domain\Administrator\Infrastructure\Model\Administrator;
use Src\Domain\Profile\Domain\AccountStatusEnum;
use Src\Domain\Profile\Infrastructure\Model\Profile;
use Tests\TestCase;
use Tymon\JWTAuth\JWT;

class CreateProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var array<Profile>
     */
    private array $profileList;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_can_not_create_profiles_without_being_authenticated()
    {
        $response = $this->postJson('/api/profiles', [
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            'email' => 'test@example.com',
            'status' => AccountStatusEnum::Active->value,
            'image' => Storage::disk('public')->get('rdm_pattern.png'),
        ]);

        $response->assertStatus(401);
    }

    public function test_can_create_profiles_while_being_authenticated()
    {
        $file = UploadedFile::fake()->create('rdm_pattern.png', 2000);

        $admin = Administrator::create(AdministratorFactory::definition([
            'email' => 'test@example.com',
            'password' => 'password',
        ]));

        $token = app(JWT::class)->fromUser($admin);

        $response = $this->post('/api/profiles', [
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            'email' => 'test@gmail.com',
            'status' => AccountStatusEnum::Active->value,
            'image' => $file,
        ], [
            'Content-Type' => 'multipart/form-data',
            'Authorization' => "Bearer $token",
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'firstname',
            'lastname',
            'email',
            'email',
            'image',
            'created_at',
            'updated_at',
        ]);

        $this->assertTrue(Storage::disk('public')->exists(basename($response->json('image'))));
        Storage::disk('public')->delete(basename($response->json('image')));
    }
}
