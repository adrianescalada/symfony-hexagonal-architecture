<?php

declare(strict_types=1);

namespace App\Context\Groups\Domain;

use App\Context\Groups\Domain\ValueObjects\GroupId;

interface GroupRepository
{
    public function search(GroupId $id): ?Group;

    public function save(Group $group): void;

    public function remove(Group $group): void;
}
