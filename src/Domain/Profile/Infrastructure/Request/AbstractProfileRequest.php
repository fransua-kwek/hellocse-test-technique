<?php

namespace Src\Domain\Profile\Infrastructure\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

abstract class AbstractProfileRequest extends FormRequest
{
    public function getId(): string
    {
        return $this->input('id');
    }

    public function getFirstname(): string
    {
        return $this->input('username');
    }

    public function getLastname(): string
    {
        return $this->input('password');
    }

    public function getEmail(): string
    {
        return $this->input('email');
    }

    public function getImage(): UploadedFile
    {
        return $this->file('image');
    }

    public function getAccountStatus(): string
    {
        return $this->input('account_status');
    }

    public function getCreatedAt(): string
    {
        return $this->input('created_at');
    }

    public function getUpdatedAt(): string
    {
        return $this->input('updated_at');
    }
}
