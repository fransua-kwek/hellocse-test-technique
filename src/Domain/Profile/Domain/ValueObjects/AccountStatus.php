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
        if ($this->accountStatus !== null) {
            $error = !in_array($this->accountStatus, AccountStatusEnum::CASES_NAME) && AccountStatusEnum::toName($this->accountStatus) === null;

            if ($error) {
                throw new Exception('Must be a correct status !');
            }
        }
    }

    public function __toString(): string
    {
        return $this->accountStatus ?? '';
    }
}
