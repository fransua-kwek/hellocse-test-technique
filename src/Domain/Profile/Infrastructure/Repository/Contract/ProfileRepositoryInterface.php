<?php

namespace Src\Domain\Profile\Infrastructure\Repository\Contract;

use Illuminate\Pagination\LengthAwarePaginator;

interface ProfileRepositoryInterface
{
    public function getProfileList(int $currentPage): LengthAwarePaginator;
}
