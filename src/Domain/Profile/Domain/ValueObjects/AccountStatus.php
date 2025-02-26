<?php

namespace Src\Domain\Profile\Domain\ValueObjects;

use Exception;
use Src\Domain\Profile\Domain\AccountStatusEnum;

final readonly class AccountStatus
{
    /**
     * @throws Exception
     */
    public function __construct(private ?string $accountStatus)
    {
        $error = ! in_array($accountStatus, AccountStatusEnum::CASES_NAME);

        $error = AccountStatusEnum::toName($accountStatus) === null;

        if ($error) {
            throw new Exception('Must be a correct status !');
        }
    }

    public function __toString(): string
    {
        return $this->accountStatus ?? '';
    }
}
