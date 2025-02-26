<?php

namespace Src\Domain\Profile\Domain;

enum AccountStatusEnum: string
{
    case Inactive = 'inactive';
    case Active = 'active';
    case WaitingApproval = 'waiting_approval';

    const array CASES_NAME = [
        'Inactif',
        'Actif',
        'En attente',
    ];

    public static function toName(string $value): ?string
    {
        return match ($value) {
            self::Active->value => 'Actif',
            self::Inactive->value => 'Inactif',
            self::WaitingApproval->value => 'En attente',
            default => null,
        };
    }
}
