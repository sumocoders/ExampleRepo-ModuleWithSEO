<?php

namespace Backend\Modules\Example\Domain\Example;

use Backend\Modules\Example\Domain\Example\Status\Status;
use Doctrine\ORM\QueryBuilder;
use Frontend\Modules\Profiles\Engine\Profile;
use Common\Core\Model;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\Expr\Join;
use Locale;

class ExampleRepository extends ServiceEntityRepository
{
    public const PAGINATE_ITEMS = 12;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Example::class);
    }

    public function add(Example $example): void
    {
        $this->getEntityManager()->persist($example);
        $this->getEntityManager()->flush($example);
    }


    public function save(Example $example): void
    {
        $this->getEntityManager()->flush($example);
    }

    public function remove(Example $example): void
    {
        $this->getEntityManager()->remove($example);
        $this->getEntityManager()->flush($example);
    }

    public function findVisibleExamples(string $locale): array
    {
        return $this->createQueryBuilder('i')
            ->innerJoin('i.exampleLocalised', 'e')
            ->where('i.visible = :visible')
            ->andWhere('e.locale = :locale')
            ->setParameter('visible', true)
            ->setParameter('locale', $locale)
            ->orderBy('i.sequence', 'asc')
            ->getQuery()
            ->getResult();
    }

    public function findFinishedExamples(string $locale): array
    {
        return $this->createQueryBuilder('i')
            ->where('i.status = :status')
            ->andWhere('e.locale = :locale')
            ->setParameter('status', Status::FINISHED)
            ->setParameter('locale', $locale)
            ->orderBy('i.sequence', 'asc')
            ->getQuery()
            ->getResult();
    }

    public function findBySlugAndLocale(string $slug, string $locale): ?Example
    {
        try {
            return $this
                ->createQueryBuilder('i')
                ->innerJoin('i.exampleLocalised', 'e')
                ->innerJoin('e.meta', 'm', Join::WITH, 'm.url = :slug')
                ->where('e.locale = :locale')
                ->setParameter('slug', $slug)
                ->setParameter('locale', $locale)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException | NonUniqueResultException $resultException) {
            return null;
        }
    }

    public function getUrl(string $url, int $id = null): string
    {
        $query = $this
            ->createQueryBuilder('i')
            ->select('COUNT(i)')
            ->innerJoin('i.exampleLocalised', 'e')
            ->innerJoin('e.meta', 'm')
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
}
