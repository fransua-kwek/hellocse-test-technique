<?php

namespace App\Http\Controllers\Profiles;

use Illuminate\Http\JsonResponse;
use Src\Domain\Profile\Application\Dto\ProfileData;
use Src\Domain\Profile\Application\ProfileService;
use Src\Domain\Profile\Infrastructure\Model\Profile;

class DeleteProfile
{
    public function __construct(readonly private ProfileService $profileService)
    {
    }

    public function __invoke(Profile $profile): JsonResponse
    {
        $result = $this->profileService->deleteById($profile->id, $profile->image);

        return response()->json([
            'deleted' => $result,
            'profile' => ProfileData::fromEloquent($profile)->toArray()
        ]);
    }
}
