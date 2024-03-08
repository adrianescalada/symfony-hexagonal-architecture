<?php

declare(strict_types=1);

namespace App\Context\Groups\Application;

use App\Context\Groups\Domain\GroupNotExist;
use App\Context\Groups\Domain\GroupRepository;
use App\Context\Groups\Domain\GroupWithUsers;
use App\Context\Groups\Domain\ValueObjects\GroupId;

final class GroupRemover
{
    public function __construct(private readonly GroupRepository $repository)
    {
    }

    public function __invoke(string $id): void
    {
        $id = new GroupId($id);
        $group = $this->repository->search($id);

        if (null === $group) {
            throw new GroupNotExist($id);
        }

        if ($group->hasUsers()) {
            throw new GroupWithUsers($id);
        }

        $this->repository->remove($group);
    }
}
