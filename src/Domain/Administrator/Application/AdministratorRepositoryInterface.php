<?php

namespace Src\Domain\Administrator\Application;

use Src\Domain\Administrator\Infrastructure\Model\Administrator;

interface AdministratorRepositoryInterface
{
    public function getByEmail(string $email): ?Administrator;
}
