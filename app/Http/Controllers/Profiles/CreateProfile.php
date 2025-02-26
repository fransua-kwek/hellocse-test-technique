<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Requests\Profiles\CreateProfileRequest;
use Illuminate\Http\JsonResponse;
use Src\Domain\Profile\Application\Dto\ProfileData;
use Src\Domain\Profile\Application\ProfileService;

class CreateProfile
{
    public function __construct(private readonly ProfileService $profileService) {}

    /**
     * @throws \Exception
     */
    public function __invoke(CreateProfileRequest $request): JsonResponse
    {
        $profile = ProfileData::fromRequest($request);

        $profile = $this->profileService->createProfile($profile);

        return response()->json($profile->toArray());
    }
}
