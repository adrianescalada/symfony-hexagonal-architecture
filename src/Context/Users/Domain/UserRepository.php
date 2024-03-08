<?php

declare(strict_types=1);

namespace App\Context\Users\Domain;

use App\Context\Users\Application\Filter\UserFilter;
use App\Context\Users\Application\DTO\Response\PaginatedResponse;
use App\Context\Users\Domain\ValueObjects\UserId;

interface UserRepository
{
    public function findOneByIdOrFail(UserId $id): User;

    public function search(UserFilter $filter): ?PaginatedResponse;

    public function save(User $user): void;

    public function remove(User $user): void;
}
