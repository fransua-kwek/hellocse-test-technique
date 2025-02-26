<?php

namespace Src\Domain\Profile\Domain\ValueObjects;

use Exception;

final readonly class Firstname
{
    /**
     * @throws Exception
     */
    public function __construct(private string $firstname)
    {
        if (empty($this->firstname)) {
            throw new Exception('Firstname must be a non-empty string !');
        }
    }

    public function __toString(): string
    {
        return $this->firstname;
    }
}
