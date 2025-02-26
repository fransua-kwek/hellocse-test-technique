<?php

namespace Src\Domain\Profile\Application;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\UploadedFile;
use Src\Domain\Image\Application\ImageService;
use Src\Domain\Image\Domain\ValueObjects\Image;
use Src\Domain\Profile\Application\Dto\ProfileData;
use Src\Domain\Profile\Domain\Profile;
use Src\Domain\Profile\Domain\ValueObjects\AccountStatus;
use Src\Domain\Profile\Domain\ValueObjects\Email;
use Src\Domain\Profile\Domain\ValueObjects\Firstname;
use Src\Domain\Profile\Domain\ValueObjects\Lastname;
use Src\Domain\Profile\Domain\ValueObjects\Timestamp;
use Src\Domain\Profile\Domain\ValueObjects\Uuid;
use Src\Domain\Profile\Infrastructure\Repository\Contract\ProfileRepositoryInterface;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWT;

readonly class ProfileService
{
    public function __construct(
        private ProfileRepositoryInterface $profileRepository,
        private ImageService $imageService,
        private JWT $jwt,
    ) {}

    /**
     * @return array{
     *     items: ProfileData[],
     *     total: int,
     *     per_page: int,
     *     current_page: int
     * }
     *
     * @throws Exception
     */
    public function getProfileList(int $currentPage): array
    {

        $paginateResult = $this->profileRepository->getProfileList($currentPage);

        // remove account_status from selected columns when user is not auth
        try {
            $this->jwt->parseToken();
            $userConnected = true;
        } catch (JWTException $e) {
            $userConnected = false;
        }

        $items = [];
        foreach ($paginateResult->items() as $item) {
            $items[] = (new Profile(
                $item->id,
                new Firstname($item->firstname),
                new Lastname($item->lastname),
                new Email($item->email),
                new Image(null, $item->image),
                new AccountStatus($userConnected ? $item->account_status : null),
                new Timestamp($item->created_at),
                new Timestamp($item->updated_at),
            ));
        }

        return [
            'items' => $items,
            'total' => $paginateResult->total(),
            'per_page' => $paginateResult->perPage(),
            'current_page' => $paginateResult->currentPage(),
        ];
    }

    /**
     * @throws Exception
     */
    public function createProfile(ProfileData $profile): ProfileData
    {
        $valueObjectImg = $profile->img instanceof UploadedFile
            ? new Image($profile->img, null)
            : new Image(null, $profile->img);

        $profile = new Profile(
            null,
            new Firstname($profile->firstname),
            new Lastname($profile->lastname),
            new Email($profile->email),
            $valueObjectImg,
            new AccountStatus($profile->accountStatus),
            new Timestamp(Carbon::now()),
            new Timestamp(Carbon::now()),
        );

        $model = $this->profileRepository->store($profile->toArray());

        if (! empty($model->id)) {
            $profile->setId($model->id);
        } else {
            throw new Exception('Error creating profile');
        }

        return ProfileData::fromDomain($profile);
    }

    /**
     * @throws Exception
     */
    public function updateProfileById(string $profileId, ProfileData $profile): array
    {
        $filepath = $profile->img;
        if ($filepath instanceof UploadedFile) {
            $oldProfileImage = $this->profileRepository->getProfileImageById($profileId);
            $this->imageService->destroy($oldProfileImage);
            $filepath = $this->imageService->store($profile->img);
        }

        $profile = new Profile(
            new Uuid($profileId),
            new Firstname($profile->firstname),
            new Lastname($profile->lastname),
            new Email($profile->email),
            new Image(null, $filepath),
            new AccountStatus($profile->accountStatus),
            new Timestamp($profile->createdAt),
            new Timestamp(Carbon::now()),
        );

        $modified = $this->profileRepository->update($profileId, $profile->toArray(true));

        return [
            'modified' => $modified,
            'profile' => ProfileData::fromDomain($profile),
        ];
    }

    public function deleteById(string $profileId): array
    {
        $profile = $this->profileRepository->getProfileById($profileId);

        $this->imageService->destroy($profile->image);

        return [
            'deleted' => $this->profileRepository->delete($profileId),
            'profile' => ProfileData::fromEloquent($profile),
        ];
    }
}
