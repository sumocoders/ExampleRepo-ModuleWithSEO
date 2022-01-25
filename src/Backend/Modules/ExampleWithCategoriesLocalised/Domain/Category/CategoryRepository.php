<?php

namespace Backend\Modules\ExampleWithCategoriesLocalised\Domain\Category;

use Common\Core\Model;
use Common\Locale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\Expr\Join;

class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function add(Category $category): void
    {
        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush($category);
    }

    public function save(Category $category): void
    {
        $this->getEntityManager()->flush($category);
    }

    public function remove(Category $category): void
    {
        $this->getEntityManager()->remove($category);
        $this->getEntityManager()->flush($category);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function findBySlug(string $slug): ?Category
    {
        try {
            return $this
                ->createQueryBuilder('i')
                ->innerJoin('i.meta', 'm', Join::WITH, 'm.url = :slug')
                ->setParameter('slug', $slug)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException | NonUniqueResultException $resultException) {
            return null;
        }
    }

    public function findForDropDown(): array
    {
        $results = $this->createQueryBuilder('c')
            ->select('c.id, c.title')
            ->orderBy('c.sequence')
            ->getQuery()
            ->getArrayResult();

        $choices = [];
        foreach ($results as $result) {
            $choices[$result['id']] = $result['title'];
        }

        return $choices;
    }

    public function getUrl(string $url, int $id = null): string
    {
        $query = $this
            ->createQueryBuilder('i')
            ->select('COUNT(i)')
            ->innerJoin('i.meta', 'm')
            ->where('m.url = :url')
            ->setParameter('url', $url);

        if ($id !== null) {
            $query
                ->andWhere('i.id != :id')
                ->setParameter('id', $id);
        }

        if ((int)$query->getQuery()->getSingleScalarResult() === 0) {
            return $url;
        }

        return $this->getUrl(Model::addNumber($url), $id);
    }

    public function getNextSequence(): int
    {
        $lastSequence = (int) $this
            ->createQueryBuilder('c')
            ->select('MAX(c.sequence)')
            ->getQuery()
            ->getSingleScalarResult();

        return $lastSequence + 1;
    }
}
