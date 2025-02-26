<?php

namespace App\Http\Controllers\Profiles;

use Illuminate\Http\JsonResponse;
use Src\Domain\Profile\Application\ProfileService;

class DeleteProfile
{
    public function __construct(readonly private ProfileService $profileService)
    {
    }

    public function __invoke(string $profileId): JsonResponse
    {
        $result = $this->profileService->deleteById($profileId);

        return response()->json([
            'row_deleted' => $result['deleted'],
            'profile' => $result['profile']->toArray()
        ]);
    }
}
