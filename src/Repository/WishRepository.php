<?php

namespace App\Repository;

use App\Entity\Wish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Wish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wish[]    findAll()
 * @method Wish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wish::class);
    }


    public function findBestWishes(){

        //Avec le QueryBuilder

        $queryBuilder = $this->createQueryBuilder('w');

        $queryBuilder->andWhere('w.note > 8')
                    ->addOrderBy('w.note', 'DESC');

        $queryBuilder->leftJoin('w.category', 'category');

        $queryBuilder->addSelect('category');

        $query = $queryBuilder->getQuery();

        $query->setMaxResults(50);

        $paginator = new Paginator($query);

        return $paginator;
    }
}
