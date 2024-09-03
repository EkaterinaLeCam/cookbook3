<?php

namespace App\Repository;

use App\Entity\Recette;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Void_;

/**
 * @extends ServiceEntityRepository<Recette>
 */
class RecetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recette::class);
    }
  

    public function findByQuery(string $query): array
    {
        return $this->createQueryBuilder('r')
            ->where('r.nom LIKE :query OR r.preparation LIKE :query')
            ->setParameter('query', "%$query%")
            ->getQuery()
            ->getResult();
    }
}