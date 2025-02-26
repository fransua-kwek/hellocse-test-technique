<?php

namespace Src\Domain\Profile\Infrastructure\Repository;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Src\Domain\Profile\Domain\AccountStatusEnum;
use Src\Domain\Profile\Infrastructure\Model\Profile;
use Src\Domain\Profile\Infrastructure\Repository\Contract\ProfileRepositoryInterface;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function getProfileList(int $currentPage): LengthAwarePaginator
    {
        return Profile::query()->where('account_status', AccountStatusEnum::Active)->paginate(3, ['*'], 'page', $currentPage);
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

    /**
     * @param string $profileId
     * @return Profile|null
     * @throws ModelNotFoundException<Profile>
     */
    public function getProfileById(string $profileId): ?Profile
    {
        return Profile::query()->where('id', $profileId)->firstOrFail();
    }
}
