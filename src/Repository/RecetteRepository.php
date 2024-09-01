<?php

namespace App\Repository;

use App\Entity\Recette;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recette>
 */
class RecetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recette::class);
    }

    public function findRecetteByElement($recettes )
    {
        $c = $this->createQueryBuilder('recettes');
     
        


        return $c->getQuery()->getResult();
    }




}
