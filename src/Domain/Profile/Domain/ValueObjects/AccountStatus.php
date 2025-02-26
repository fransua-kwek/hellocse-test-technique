<?php

namespace Src\Domain\Profile\Domain\ValueObjects;

use Exception;
use Src\Domain\Profile\Domain\AccountStatusEnum;

final readonly class AccountStatus
{
    /**
     * @param string|null $accountStatus
     * @throws Exception
     */
    public function __construct(private ?string $accountStatus)
    {
        if (!empty($accountStatus) && !in_array($accountStatus, AccountStatusEnum::CASES_NAME)) {
            throw new Exception('Must be a correct status !');
        }
    }

    public function __toString(): string
    {
        return $this->accountStatus ?? '';
    }
}
