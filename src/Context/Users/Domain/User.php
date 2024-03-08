<?php

namespace App\Context\Users\Domain;

use App\Context\Groups\Domain\Group;
use App\Context\Users\Domain\ValueObjects\UserId;
use App\Context\Users\Domain\ValueObjects\UserName;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class User
{
    private Collection $groups;

    public function __construct(private readonly UserId $id, private UserName $name)
    {
        $this->groups = new ArrayCollection();
    }

    public static function create(UserId $id, UserName $name): self
    {
        return new self($id, $name);
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function rename(UserName $name): void
    {
        $this->name = $name;
    }

    public function addGroup(Group $group): void
    {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
        }
    }

    public function removeGroup(Group $group): void
    {
        $this->groups->removeElement($group);
    }
}
