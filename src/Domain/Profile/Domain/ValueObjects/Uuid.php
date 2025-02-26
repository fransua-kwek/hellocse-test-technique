<?php

namespace Src\Domain\Profile\Domain\ValueObjects;

use Exception;

final readonly class Uuid
{
    /**
     * @throws Exception
     */
    public function __construct(private string $id)
    {
        if (is_string($this->id) === true && ! uuid_is_valid($id)) {
            throw new Exception('Must be a correct status !');
        }
    }

    public function __toString(): string
    {
        return $this->id ?? '';
    }
}
