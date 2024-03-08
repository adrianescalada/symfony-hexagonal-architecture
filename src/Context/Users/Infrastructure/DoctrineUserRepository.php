<?php

namespace App\Context\Users\Infrastructure;

use App\Context\Users\Domain\User;
use App\Context\Users\Domain\UserRepository;
use App\Context\Users\Domain\ValueObjects\UserId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Context\Users\Application\Filter\UserFilter;
use App\Context\Users\Application\DTO\Response\PaginatedResponse;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Context\Users\Infrastructure\Exception\ResourceNotFoundException;

/**
 * @extends ServiceEntityRepository<User>
 *
 */
class DoctrineUserRepository extends ServiceEntityRepository implements UserRepository
{
    private readonly ServiceEntityRepository $repository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
        $this->repository = new ServiceEntityRepository($registry, User::class);
    }

    public function findOneByIdOrFail(UserId $id): User
    {
        if (null === $user = $this->repository->find($id)) {
            throw ResourceNotFoundException::createFromResourceAndId(User::class, $id);
        }

        return $user;
    }

    public function search(UserFilter $filter): ?PaginatedResponse
    {
        $page = $filter->page;
        $limit = $filter->limit;
        $sort = $filter->sort;
        $order = $filter->order;
        $name = $filter->name;

        $qb = $this->repository->createQueryBuilder('u');
        if (null === $sort) {
            $qb->orderBy('u.id', 'ASC');
        } else {
            $field = $sort === 'name' ? 'u.name.value' : ($sort === 'id' ? 'u.id' : "u.$sort");
            $qb->orderBy($field, $order ?: 'ASC');
        }

        if (null !== $name) {

            $qb
                ->andWhere('u.name.value LIKE :name')
                ->setParameter(':name', '%' . $name . '%');
        }

        $query = $qb->getQuery();

        $paginator = new Paginator($query);
        $paginator
            ->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        $results = $paginator->getIterator()->getArrayCopy();

        return PaginatedResponse::create($results, $paginator->count(), $page, $limit);
    }

    public function save(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function remove(User $user): void
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }
}
