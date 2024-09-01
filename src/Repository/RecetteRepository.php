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

    public function findRecetteByElement($categorie )
    {
        $c = $this->createQueryBuilder('recettes');
        //On s'assure que la categorie de recette n'est pas null
        if ($categorie !== null){
            $c->where('recettes.categorie >= :categorie')
               ->setParameter('categorie', $categorie);
        }
        


        return $c->getQuery()->getResult();
    }




}
