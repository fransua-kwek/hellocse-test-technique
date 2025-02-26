<?php

namespace Src\Domain\Profile\Infrastructure\Model\Cast;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Src\Domain\Profile\Domain\AccountStatusEnum;

class AccountStatusCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): string
    {
        return AccountStatusEnum::toName($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        return $value;
    }
}
