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

   //public function findBySearch(SearchData $searchData)
    //{
       // $data= $this;
        //if(!empty($searchData->q))
      //  {
      //      $data=$data->setParameter('q', "%{$searchData->q}%");
       // }
       // $data=$data
       // ->getQuery()
       // ->getResult();

       // $recettes = $this->paginatorInterface->paginate($data, $searchData->page, 9);
       // return $recettes;
    //}


}
