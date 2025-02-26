<?php

namespace Src\Domain\Profile\Application\Dto;

use Illuminate\Http\UploadedFile;
use Src\Domain\Profile\Domain\Profile;
use Src\Domain\Profile\Infrastructure\Request\AbstractProfileRequest;

readonly class ProfileData
{
    public function __construct(
        public ?string $id,
        public string $firstname,
        public string $lastname,
        public string $email,
        public UploadedFile|string $img,
        public ?string $accountStatus,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {}

    public static function fromRequest(AbstractProfileRequest $request): self
    {
        return new static(
            $request->getId(),
            $request->getFirstname(),
            $request->getLastname(),
            $request->getEmail(),
            $request->getImage(),
            $request->getAccountStatus(),
            $request->getCreatedAt(),
            $request->getUpdatedAt()
        );
    }

    public static function fromDomain(Profile $profile): self
    {
        return new static(
            $profile->id,
            $profile->firstname->__toString(),
            $profile->lastname->__toString(),
            $profile->email->__toString(),
            $profile->img->__toString(),
            $profile->accountStatus->__toString(),
            $profile->createdAt->__toString(),
            $profile->updatedAt->__toString(),
        );
    }

    public function toArray(): array
    {
        $array = [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'image' => asset('storage/' . $this->img),
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];

        if (!empty($this->accountStatus)) {
            $array['status'] = $this->accountStatus;
        }

        return $array;
    }
}
