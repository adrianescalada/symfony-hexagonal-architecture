<?php

declare(strict_types=1);

namespace App\Context\Users\Application;

use App\Context\Groups\Domain\GroupNotExist;
use App\Context\Groups\Domain\GroupRepository;
use App\Context\Groups\Domain\ValueObjects\GroupId;
use App\Context\Users\Domain\UserNotExist;
use App\Context\Users\Domain\UserRepository;
use App\Context\Users\Domain\ValueObjects\UserId;

final class UserGroupAdder
{
    public function __construct(private readonly UserRepository $userRepository, private readonly GroupRepository $groupRepository)
    {
    }

    public function __invoke(string $userId, string $groupId): void
    {
        $userId = new UserId($userId);
        $user = $this->userRepository->findOneByIdOrFail($userId);

        if (null === $user) {
            throw new UserNotExist($userId);
        }

        $groupId = new GroupId($groupId);
        $group = $this->groupRepository->search($groupId);

        if (null === $group) {
            throw new GroupNotExist($groupId);
        }

        $user->addGroup($group);

        $this->userRepository->save($user);
    }
}
