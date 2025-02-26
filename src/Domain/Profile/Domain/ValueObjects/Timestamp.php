<?php

namespace Src\Domain\Profile\Domain\ValueObjects;

use DateTime;
use Exception;

final readonly class Timestamp
{
    public function __construct(private readonly string $timestamp)
    {
        /**
         * @param  string  $lastname
         *
         * @throws Exception
         */
        if (empty($this->timestamp) && ! $this->timestamp instanceof DateTime) {
            throw new Exception('timestamp must be a valid date !');
        }
    }

    public function __toString(): string
    {
        return $this->timestamp;
    }
}
