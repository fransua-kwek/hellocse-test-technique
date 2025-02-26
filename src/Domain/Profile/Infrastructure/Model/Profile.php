<?php

namespace Src\Domain\Profile\Infrastructure\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Src\Domain\Profile\Infrastructure\Model\Cast\AccountStatusCast;

class Profile extends Model
{
    use HasUuids;

    protected $table = 'profiles';

    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'firstname',
        'lastname',
        'email',
        'image',
        'account_status',
    ];

    protected $casts = [
        'account_status' => AccountStatusCast::class,
    ];
}
