<?php

namespace Backend\Modules\Examples\Domain;

use Backend\Modules\Examples\Domain\Entity\Example;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ExampleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Example::class);
    }

    public function add(Example $example): void
    {
        $this->getEntityManager()->persist($example);
        $this->getEntityManager()->flush($example);
    }

    public function update(Example $example): void
    {
        $this->getEntityManager()->flush($example);
    }

    public function remove(Example $example): void
    {
        $this->getEntityManager()->remove($example);
        $this->getEntityManager()->flush($example);
    }

    public function getNextSequence(): int
    {
        $lastSequence = (int) $this
            ->createQueryBuilder('e')
            ->select('MAX(e.sequence)')
            ->getQuery()
            ->getSingleScalarResult();

        return $lastSequence + 1;
    }

}
