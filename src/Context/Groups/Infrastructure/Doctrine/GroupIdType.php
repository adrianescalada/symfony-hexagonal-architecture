<?php

declare(strict_types=1);

namespace App\Context\Groups\Infrastructure\Doctrine;

use App\Context\Groups\Domain\ValueObjects\GroupId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class GroupIdType extends StringType
{
    public const NAME = 'group_id';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new GroupId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->value();
    }
}
