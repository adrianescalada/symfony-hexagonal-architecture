<?php

namespace App\Context\Groups\Domain;

use App\Context\Groups\Domain\ValueObjects\GroupId;
use App\Context\Groups\Domain\ValueObjects\GroupName;
use App\Context\Users\Domain\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class Group
{
    private Collection $users;
    public function __construct(private readonly GroupId $id, private GroupName $name)
    {
        $this->users = new ArrayCollection();
    }

    public static function create(GroupId $id, GroupName $name): self
    {
        return new self($id, $name);
    }

    public function id(): GroupId
    {
        return $this->id;
    }

    public function name(): GroupName
    {
        return $this->name;
    }


    public function rename(GroupName $name): void
    {
        $this->name = $name;
    }

    public function addUser(User $user): void
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }
    }

    public function hasUsers()
    {
        return !$this->users->isEmpty();
    }
}
