<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Src\Domain\Administrator\Infrastructure\Database\Factories\AdministratorFactory;
use Src\Domain\Administrator\Infrastructure\Model\Administrator;
use Src\Domain\Profile\Domain\AccountStatusEnum;
use Src\Domain\Profile\Infrastructure\Model\Profile;
use Tests\TestCase;
use Tymon\JWTAuth\JWT;

class UpdateProfileTest extends TestCase
{
    use RefreshDatabase;

    private string $filename;
    private string $profileId;
    private string $token;
    private string $created_at;

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
        $this->created_at = $response->json('created_at');
    }

    public function test_can_not_update_profiles_without_being_authenticated()
    {
        $response = $this->postJson('/api/profiles/'.$this->profileId);

        $response->assertStatus(401);
    }

    public function test_can_update_profiles_while_being_authenticated()
    {
        $file = UploadedFile::fake()->create('rdm_pattern.png', 2000);

        $response = $this->post('/api/profiles/' . $this->profileId, [
            'firstname' => 'firstname_modified',
            'lastname' => 'lastname_modified',
            'email' => 'test-modified@gmail.com',
            'status' => AccountStatusEnum::Inactive->value,
            'image' => $file,
            'created_at' => '2021-01-01 00:00:00',
        ], [
            'Content-Type' => 'multipart/form-data',
            'Authorization' => "Bearer $this->token",
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'modified',
            'profile',
        ]);

        $profile = Profile::where('id', $this->profileId)->first();

        $this->assertEquals('firstname_modified', $profile->firstname);
        $this->assertEquals('lastname_modified', $profile->lastname);
        $this->assertEquals('test-modified@gmail.com', $profile->email);
        $this->assertEquals(AccountStatusEnum::toName(AccountStatusEnum::Inactive->value), $profile->account_status);
        $this->assertEquals(basename($response->json('profile.image')), $profile->image);
        $this->assertEquals($this->created_at, $profile->created_at);
        $this->assertTrue(Storage::disk('public')->exists(basename($response->json('profile.image'))));

        $this->assertFalse(Storage::disk('public')->exists(basename($this->filename)));
    }
}
