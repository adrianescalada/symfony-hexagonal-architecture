<?php

declare(strict_types=1);

namespace App\Context\Users\Application;

use App\Context\Users\Domain\UserNotExist;
use App\Context\Users\Domain\UserRepository;
use App\Context\Users\Domain\ValueObjects\UserId;

final class UserRemover
{
    public function __construct(private readonly UserRepository $repository)
    {
    }

    public function __invoke(string $id): void
    {
        $id = new UserId($id);
        $user = $this->repository->findOneByIdOrFail($id);

        if (null === $user) {
            throw new UserNotExist($id);
        }

        $this->repository->remove($user);
    }
}
