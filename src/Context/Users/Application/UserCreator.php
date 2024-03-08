<?php

declare(strict_types=1);

namespace App\Context\Users\Application;

use App\Context\Users\Domain\User;
use App\Context\Users\Domain\UserRepository;
use App\Context\Users\Domain\ValueObjects\UserId;
use App\Context\Users\Domain\ValueObjects\UserName;

final class UserCreator
{
    public function __construct(private readonly UserRepository $repository)
    {
    }

    public function __invoke(string $id, string $name): void
    {
        $id = new UserId($id);
        $name = new UserName($name);

        $user = User::create($id, $name);

        $this->repository->save($user);
    }
}
