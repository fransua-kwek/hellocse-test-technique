<?php

namespace Src\Domain\Profile\Infrastructure\Repository\Contract;

use Illuminate\Pagination\LengthAwarePaginator;
use Src\Domain\Profile\Infrastructure\Model\Profile;

interface ProfileRepositoryInterface
{
    public function getProfileList(int $currentPage): LengthAwarePaginator;

    public function store(array $profile): Profile;

    public function update(string $profileId, array $profile): bool;

    public function delete(string $profileId): int;

    public function getProfileImageById(string $profileId): ?string;

    public function getProfileById(string $profileId): ?Profile;
}
