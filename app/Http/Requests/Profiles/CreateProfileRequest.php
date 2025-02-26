<?php

namespace App\Http\Requests\Profiles;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Src\Domain\Profile\Domain\AccountStatusEnum;
use Src\Domain\Profile\Infrastructure\Request\AbstractProfileRequest;

class CreateProfileRequest extends AbstractProfileRequest
{
    public function rules(): array
    {
        return [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'image' => [
                'required',
                File::image()->max(2000),
            ],
            'email' => 'required|email:rfc,dns|unique:profiles',
            'status' => ['required', 'string', Rule::enum(AccountStatusEnum::class)],
        ];
    }
}
