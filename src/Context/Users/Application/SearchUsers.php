<?php

declare(strict_types=1);

namespace App\Context\Users\Application;

use App\Context\Users\Domain\UserRepository;
use App\Context\Users\Application\Filter\UserFilter;
use App\Context\Users\Application\DTO\SearchUsersOutput;

final class SearchUsers
{
    public function __construct(private readonly UserRepository $repository)
    {
    }

    public function execute(UserFilter $filter): SearchUsersOutput
    {
        $paginatedResponse = $this->repository->search($filter);

        return SearchUsersOutput::createFromPaginatedResponse($paginatedResponse);
    }
}
