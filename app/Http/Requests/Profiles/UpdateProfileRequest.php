<?php

namespace App\Http\Requests\Profiles;

use App\Rules\VerifyUniqueEmail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Src\Domain\Profile\Domain\AccountStatusEnum;
use Src\Domain\Profile\Infrastructure\Request\AbstractProfileRequest;

class UpdateProfileRequest extends AbstractProfileRequest
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
            'email' => ['required', 'email:rfc,dns', new VerifyUniqueEmail($this->route('id'))],
            'status' => ['required', 'string', Rule::enum(AccountStatusEnum::class)],
            'created_at' => ['required', 'date'],
        ];
    }
}
