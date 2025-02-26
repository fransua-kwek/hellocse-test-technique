<?php

namespace Src\Domain\Profile\Domain\ValueObjects;

use Exception;

final readonly class Email
{
    /**
     * @throws Exception
     */
    public function __construct(private string $email)
    {
        if (empty($this->email)) {
            throw new Exception('Email must be a non-empty string !');
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email must be a valid email address !');
        }
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
