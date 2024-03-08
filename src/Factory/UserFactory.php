<?php

namespace App\Factory;

use App\Context\Users\Domain\User;
use App\Context\Users\Domain\ValueObjects\UserId;
use App\Context\Users\Domain\ValueObjects\UserName;
use Faker\Factory as FakerFactory;

class UserFactory
{
    public static function create(): User
    {
        $faker = FakerFactory::create();

        $userId = new UserId($faker->uuid());
        $userName = new UserName($faker->company);

        $user = new User($userId, $userName);

        return $user;
    }
}
