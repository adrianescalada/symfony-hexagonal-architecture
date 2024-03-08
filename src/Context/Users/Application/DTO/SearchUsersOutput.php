<?php

declare(strict_types=1);

namespace App\Context\Users\Application\DTO;

use App\Context\Users\Application\DTO\Response\PaginatedResponse;
use App\Context\Users\Domain\User;

final class SearchUsersOutput
{
    private function __construct(
        public readonly array $user
    ) {
    }

    public static function createFromPaginatedResponse(PaginatedResponse $paginatedResponse): self
    {
        $items = \array_map(function (User $user): array {
            return [
                'id' => $user->id()->value(),
                'name' => $user->name()->value(),
            ];
        }, $paginatedResponse->getItems());

        $response['items'] = $items;
        $response['meta'] = $paginatedResponse->getMeta();

        return new SearchUsersOutput($response);
    }
}
