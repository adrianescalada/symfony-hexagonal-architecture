<?php

namespace App\Context\Groups\Infrastructure;

use App\Context\Groups\Domain\Group;
use App\Context\Groups\Domain\GroupRepository;
use App\Context\Groups\Domain\ValueObjects\GroupId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Group>
 *
 */
class DoctrineGroupRepository extends ServiceEntityRepository implements GroupRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Group::class);
    }

    public function search(GroupId $id): ?Group
    {
        return $this->getEntityManager()->find(Group::class, $id);
    }

    public function save(Group $group): void
    {
        $this->getEntityManager()->persist($group);
        $this->getEntityManager()->flush();
    }

    public function remove(Group $group): void
    {
        $this->getEntityManager()->remove($group);
        $this->getEntityManager()->flush();
    }
}
