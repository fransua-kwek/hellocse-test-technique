<?php

namespace Src\Domain\Profile\Domain;

use Src\Domain\Image\Domain\ValueObjects\Image;
use Src\Domain\Profile\Domain\ValueObjects\AccountStatus;
use Src\Domain\Profile\Domain\ValueObjects\Email;
use Src\Domain\Profile\Domain\ValueObjects\Firstname;
use Src\Domain\Profile\Domain\ValueObjects\Lastname;
use Src\Domain\Profile\Domain\ValueObjects\Timestamp;

class Profile
{
    public function __construct(
        public ?string       $id,
        public Firstname     $firstname,
        public Lastname      $lastname,
        public Email         $email,
        public Image         $img,
        public AccountStatus $accountStatus,
        public Timestamp     $createdAt,
        public Timestamp     $updatedAt,
    ) {}

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'image' => $this->img->__toString(),
            'account_status' => $this->accountStatus,
            'created_At' => $this->createdAt,
            'updated_At' => $this->updatedAt,
        ];
    }
}
