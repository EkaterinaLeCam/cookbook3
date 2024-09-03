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
  
    /**
     * Get published recettes thanks to Search Data value
     * 
     * @param SearchData $searchData
     * @return PaginationInterface
     */

    public function findBySearch(SearchData $searchData):array 
    {

        $data=$this->createQueryBuilder('r')
        ->where('r.brouillon LIKE :brouillon')
        ->setParameter('brouillon', '%STATE_PUBLISHED%')
        ->addOrderBy('r.created_at', 'DESC');

        if(!empty($searchData->q))
        {
            $data=$data
            ->andWhere('r.nom LIKE:q')
            ->setParameter('q',"%{$searchData->q}%");
        }
        $data=$data
        ->getQuery()
        ->getResult();

        $recettes=$this->$paginatorInterface->paginate($data, $searchData->page, 10);

        return $recettes;

    }
   




}
