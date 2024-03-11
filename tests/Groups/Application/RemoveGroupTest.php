<?php

declare(strict_types=1);

namespace App\Tests\Groups\Application;

use App\Context\Groups\Application\GroupRemover;
use App\Context\Groups\Domain\Group;
use App\Context\Groups\Domain\GroupNotExist;
use App\Context\Groups\Domain\GroupRepository;
use App\Context\Groups\Domain\GroupWithUsers;
use App\Context\Groups\Domain\ValueObjects\GroupId;
use App\Context\Groups\Domain\ValueObjects\GroupName;
use App\Context\Users\Domain\User;
use App\Context\Users\Domain\ValueObjects\UserId;
use App\Context\Users\Domain\ValueObjects\UserName;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RemoveGroupTest extends KernelTestCase
{
    const UUID = '0ef4076c-3824-451a-ae83-6bcfa45c9819';
    const USER_NAME = 'Jan';
    const GROUP_NAME = 'admin';
    private GroupRepository $repository;

    /** @test */
    public function it_should_remove_a_valid_group(): void
    {
        $groupId = new GroupId(self::UUID);
        $name = new GroupName(self::GROUP_NAME);
        $group = new Group($groupId, $name);

        $this->shouldSearch($groupId);
        $this->shouldRemove($group);

        $groupRemover = new GroupRemover($this->repository);
        $groupRemover->__invoke(self::UUID);
    }

    /** @test */
    public function it_should_throw_uuid_exception_when_removing_a_group(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $groupId = new GroupId('');
        $name = new GroupName(self::USER_NAME);
        $group = new Group($groupId, $name);

        $this->shouldSearch($groupId);
        $this->shouldRemove($group);

        $groupRemover = new GroupRemover($this->repository);
        $groupRemover->__invoke('');
    }

    /** @test */
    public function it_should_throw_group_not_exists_exception_when_removing_a_group(): void
    {
        $groupId = new GroupId(self::UUID);

        $this->shouldSearchNull($groupId);

        $this->expectException(GroupNotExist::class);
        $groupRemover = new GroupRemover($this->repository);
        $groupRemover->__invoke(self::UUID);
    }

    /** @test */
    public function it_should_throw_group_with_users_exception_when_removing_a_group(): void
    {
        $groupId = new GroupId(self::UUID);

        $this->shouldSearchWithUsers($groupId);

        $this->expectException(GroupWithUsers::class);
        $groupRemover = new GroupRemover($this->repository);
        $groupRemover->__invoke(self::UUID);
    }

    protected function shouldSearch(GroupId $groupId): void
    {
        $this->repository()->expects(self::once())
            ->method('search')
            ->with($groupId)
            ->willReturn(new Group($groupId, new GroupName(self::GROUP_NAME)));
    }

    protected function shouldSearchNull(GroupId $groupId): void
    {
        $this->repository()->expects(self::once())
            ->method('search')
            ->with($groupId)
            ->willReturn(null);
    }

    protected function shouldSearchWithUsers(GroupId $groupId): void
    {
        $groupWithUsers = new Group($groupId, new GroupName(self::GROUP_NAME));
        $userId = new UserId(self::UUID);
        $name = new UserName(self::USER_NAME);
        $user = new User($userId, $name);
        $groupWithUsers->addUser($user);

        $this->repository()->expects(self::once())
            ->method('search')
            ->with($groupId)
            ->willReturn($groupWithUsers);
    }

    protected function shouldRemove(Group $group): void
    {
        $this->repository()->expects(self::once())
            ->method('remove')
            ->with($group);
    }

    protected function repository()
    {
        return $this->repository = $this->repository ?? $this->createMock(GroupRepository::class);
    }
}
