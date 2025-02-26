<?php

namespace Src\Domain\Profile\Infrastructure\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

abstract class AbstractProfileRequest extends FormRequest
{
    public function getId(): ?string
    {
        return $this->input('id');
    }

    public function getFirstname(): string
    {
        return $this->input('firstname');
    }

    public function getLastname(): string
    {
        return $this->input('lastname');
    }

    public function getEmail(): string
    {
        return $this->input('email');
    }

    public function getImage(): null|string|UploadedFile
    {
        return $this->file('image') ?? $this->input('image');
    }

    public function getAccountStatus(): string
    {
        return $this->input('status');
    }

    public function getCreatedAt(): ?string
    {
        return $this->input('created_at');
    }

    public function getUpdatedAt(): ?string
    {
        return $this->input('updated_at');
    }
}
