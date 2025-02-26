<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profiles\GetProfileRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Src\Domain\Profile\Application\Dto\ProfileData;
use Src\Domain\Profile\Application\ProfileService;

class GetProfiles extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService
    ){}

    /**
     * @param GetProfileRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function __invoke(GetProfileRequest $request): JsonResponse
    {
        $profiles = $this->profileService->getProfileList($request->getCurrentPage());

        $formattedProfiles = [];
        foreach ($profiles['items'] as $profile) {
            $dto = ProfileData::fromDomain($profile);
            $formattedProfiles[] = $dto->toArray();
        }

        return response()->json([
            'items' => $formattedProfiles,
            'total' => $profiles['total'],
            'per_page' => $profiles['per_page'],
            'current_page' => $profiles['current_page'],
        ]);
    }
}
