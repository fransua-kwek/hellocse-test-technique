<?php

namespace Src\Domain\Administrator\Infrastructure\Repository;

use Src\Domain\Administrator\Application\AdministratorRepositoryInterface;
use Src\Domain\Administrator\Infrastructure\Model\Administrator;

class AdministratorRepository implements AdministratorRepositoryInterface
{
    public function getByEmail(string $email): ?Administrator
    {
        return Administrator::query()->where('email', $email)->first();
    }
}
