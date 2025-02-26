<?php

namespace Src\Domain\Profile\Infrastructure\Repository;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Src\Domain\Profile\Infrastructure\Model\Profile;
use Src\Domain\Profile\Infrastructure\Repository\Contract\ProfileRepositoryInterface;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function getProfileList(int $currentPage): LengthAwarePaginator
    {
        return Profile::query()->paginate(15, ['*'], 'page', $currentPage);
    }

    public function store(array $profile): Profile
    {
        $profile['id'] = Str::uuid();

        $newProfile = new Profile;
        $newProfile->fill($profile);
        $newProfile->save();

        return $newProfile;
    }

    public function update(string $profileId, array $profile): bool
    {
        return Profile::where('id', $profileId)->update($profile);
    }

    public function delete(string $profileId): int
    {
        return Profile::destroy($profileId);
    }

    public function getProfileImageById(string $profileId): ?string
    {
        return Profile::query()->select('image')->where('id', $profileId)->first()->image ?? null;
    }
}
