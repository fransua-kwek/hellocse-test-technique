<?php

namespace Src\Domain\Profile\Domain\ValueObjects;

use Exception;

final readonly class Lastname
{
    /**
     * @param string $lastname
     * @throws Exception
     */
    public function __construct(private string $lastname)
    {
        if (empty($this->lastname)) {
            throw new Exception('Lastname must be a non-empty string !');
        }
    }

    public function __toString(): string
    {
        return $this->lastname;
    }
}
