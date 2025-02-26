<?php

namespace Src\Domain\Profile\Infrastructure\Database\Factories;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Src\Domain\Profile\Domain\AccountStatusEnum;

class ProfileFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, string|AccountStatusEnum|null>
     */
    public static function definition(array $data): array
    {
        return [
            'id' => $data['id'] ?? Str::uuid(),
            'firstname' => $data['firstname'] ?? 'firstname',
            'lastname' => $data['lastname'] ?? 'lastname',
            'email' => $data['email'] ?? 'test@example.com',
            'image' => $data['image'] ?? 'rdm_pattern.png',
            'account_status' => $data['account_status'] ?? null,
            'created_at' => $data['created_at'] ?? Carbon::now(),
            'updated_at' => $data['updated_at'] ?? Carbon::now(),
        ];
    }
}
