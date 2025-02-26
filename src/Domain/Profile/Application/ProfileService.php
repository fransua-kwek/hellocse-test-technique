<?php

namespace Src\Domain\Profile\Application;

use Src\Domain\Image\Domain\ValueObjects\Image;
use Src\Domain\Profile\Domain\Profile;
use Src\Domain\Profile\Domain\ValueObjects\AccountStatus;
use Src\Domain\Profile\Domain\ValueObjects\Email;
use Src\Domain\Profile\Domain\ValueObjects\Firstname;
use Src\Domain\Profile\Domain\ValueObjects\Lastname;
use Src\Domain\Profile\Domain\ValueObjects\Timestamp;
use Src\Domain\Profile\Infrastructure\Repository\Contract\ProfileRepositoryInterface;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWT;

class ProfileService
{
    public function __construct(readonly private ProfileRepositoryInterface $profileRepository, private readonly JWT $jwt,)
    {
    }

    /**
     * @return array{
     *     items: Profile[],
     *     total: int,
     *     per_page: int,
     *     current_page: int
     * }
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
            $items[] = new Profile(
                $item->id,
                new Firstname($item->firstname),
                new Lastname($item->lastname),
                new Email($item->email),
                new Image(null, $item->image),
                new AccountStatus($userConnected ? $item->account_status : null),
                new Timestamp($item->created_at),
                new Timestamp($item->updated_at),
            );
        }

        return [
            'items' => $items,
            'total' => $paginateResult->total(),
            'per_page' => $paginateResult->perPage(),
            'current_page' => $paginateResult->currentPage()
        ];
    }
}
