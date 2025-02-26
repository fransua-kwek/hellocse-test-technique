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

class DeleteProfileTest extends TestCase
{
    use RefreshDatabase;

    private string $filename;

    private string $profileId;

    private string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $file = UploadedFile::fake()->create('rdm_pattern.png', 2000);

        $admin = Administrator::create(AdministratorFactory::definition([
            'email' => 'test@example.com',
            'password' => 'password',
        ]));

        $this->token = app(JWT::class)->fromUser($admin);

        $response = $this->post('/api/profiles', [
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            'email' => 'test@gmail.com',
            'status' => AccountStatusEnum::Active->value,
            'image' => $file,
        ], [
            'Content-Type' => 'multipart/form-data',
            'Authorization' => "Bearer $this->token",
        ]);

        $this->profileId = $response->json('id');
        $this->filename = $response->json('image');
    }

    public function test_can_not_delete_profiles_without_being_authenticated()
    {
        $response = $this->deleteJson('/api/profiles/'.$this->profileId);

        $response->assertStatus(401);
    }

    public function test_can_delete_profiles_while_being_authenticated()
    {
        $response = $this->deleteJson('/api/profiles/'.$this->profileId, [], [
            'Content-Type' => 'Application/json',
            'Authorization' => "Bearer $this->token",
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'row_deleted',
            'profile',
        ]);

        $notExistingProfile = Profile::where('id', $response->json('profile.id'))->first();
        $this->assertNull($notExistingProfile);
        $this->assertFalse(Storage::disk('public')->exists(basename($this->filename)));
    }
}
