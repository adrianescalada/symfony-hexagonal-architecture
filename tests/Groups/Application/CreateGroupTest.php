<?php

declare(strict_types=1);

namespace App\Tests\Groups\Application;

use App\Context\Groups\Application\GroupCreator;
use App\Context\Groups\Domain\Group;
use App\Context\Groups\Domain\GroupRepository;
use App\Context\Groups\Domain\ValueObjects\GroupId;
use App\Context\Groups\Domain\ValueObjects\GroupName;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CreateGroupTest extends KernelTestCase
{
    const UUID = '0ef4076c-3824-451a-ae83-6bcfa45c9819';
    const GROUP_NAME = 'admin';
    private GroupRepository $repository;
    /** @test */
    public function it_should_create_a_valid_Group(): void
    {
        $GroupId = new GroupId(self::UUID);
        $name = new GroupName(self::GROUP_NAME);
        $Group = new Group($GroupId, $name);

        $this->shouldSave($Group);

        $GroupCreator = new GroupCreator($this->repository);
        $GroupCreator->__invoke(self::UUID, self::GROUP_NAME);
    }

    /** @test */
    public function it_should_throw_uuid_exception_when_creating_a_Group(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $GroupId = new GroupId('');
        $name = new GroupName(self::GROUP_NAME);
        $Group = new Group($GroupId, $name);

        $this->shouldSave($Group);

        $GroupCreator = new GroupCreator($this->repository);
        $GroupCreator->__invoke('', self::GROUP_NAME);
    }

    protected function shouldSave(Group $Group): void
    {
        $this->repository = $this->createMock(GroupRepository::class);
        $this->repository->expects(self::once())
            ->method('save')
            ->with($Group);
    }
}
