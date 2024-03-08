<?php

declare(strict_types=1);

namespace App\Tests\Users\Application;

use App\Context\Users\Application\UserCreator;
use App\Context\Users\Domain\User;
use App\Context\Users\Domain\UserRepository;
use App\Context\Users\Domain\ValueObjects\UserId;
use App\Context\Users\Domain\ValueObjects\UserName;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CreateUserTest extends KernelTestCase
{
    const UUID = '0ef4076c-3824-451a-ae83-6bcfa45c9819';
    const USER_NAME = 'Jan';
    private UserRepository $repository;

    /** @test */
    public function it_should_create_a_valid_user(): void
    {
        $userId = new UserId(self::UUID);
        $name = new UserName(self::USER_NAME);
        $user = new User($userId, $name);

        $this->shouldSave($user);

        $userCreator = new UserCreator($this->repository);
        $userCreator->__invoke(self::UUID, self::USER_NAME);
    }

    /** @test */
    public function it_should_throw_uuid_exception_when_creating_a_user(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $userId = new UserId('');
        $name = new UserName(self::USER_NAME);
        $user = new User($userId, $name);

        $this->shouldSave($user);

        $userCreator = new UserCreator($this->repository);
        $userCreator->__invoke('', self::USER_NAME);
    }

    protected function shouldSave(User $user): void
    {
        $this->repository = $this->createMock(UserRepository::class);
        $this->repository->expects(self::once())
            ->method('save')
            ->with($user);
    }
}
