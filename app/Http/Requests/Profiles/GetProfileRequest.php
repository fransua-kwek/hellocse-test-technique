<?php

namespace App\Http\Requests\Profiles;

use Illuminate\Foundation\Http\FormRequest;

class GetProfileRequest extends FormRequest
{
    public function getCurrentPage(): int
    {
        return (int) $this->input('page', 1);
    }

    public function rules(): array
    {
        return [
            'page' => 'sometimes|numeric',
        ];
    }
}
