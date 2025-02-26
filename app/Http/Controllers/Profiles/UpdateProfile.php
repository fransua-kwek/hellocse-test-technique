<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Requests\Profiles\UpdateProfileRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Src\Domain\Profile\Application\Dto\ProfileData;
use Src\Domain\Profile\Application\ProfileService;
use Src\Domain\Profile\Infrastructure\Model\Profile;

class UpdateProfile
{
    public function __construct(readonly private ProfileService $profileService) {}

    /**
     * @throws Exception
     */
    public function __invoke(string $profileId, UpdateProfileRequest $request): JsonResponse
    {
        $currentProfile = ProfileData::fromRequest($request);

        $result = $this->profileService->updateProfileById($profileId, $currentProfile);

        return response()->json([
            'modified' => $result['modified'],
            'profile' => $result['profile']->toArray(),
        ]);
    }
}
