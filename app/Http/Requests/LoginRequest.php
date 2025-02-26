<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function getUserUsername(): string
    {
        return $this->input('username');
    }

    public function getUserPassword(): string
    {
        return $this->input('password');
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string',
            'password' => 'required|string',
        ];
    }
}
