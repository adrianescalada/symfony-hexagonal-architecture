<?php


namespace App\Factory;

use App\Context\Groups\Domain\Group;
use App\Context\Groups\Domain\ValueObjects\GroupId;
use App\Context\Groups\Domain\ValueObjects\GroupName;
use Faker\Factory as FakerFactory;

class GroupFactory
{
    public static function create(): Group
    {
        $faker = FakerFactory::create();

        $groupId = new GroupId($faker->uuid());
        $groupName = new GroupName($faker->company);

        $group = new Group($groupId, $groupName);

        return $group;
    }
}
