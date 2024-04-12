<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 *
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }



    /**
     * This method allow us to find public recipes based on number of recipes
     *
     * @param integer $nbRecipe
     * @return array
     */
    public function findPublicRecipe(?int $nbRecipe): ?array 
    {
        
        $queryBuider = $this->createQueryBuilder("r")
        ->where("r.isPublic = 1")
        ->orderBy("r.createdAt", 'DESC');

        if ($nbRecipe !== 0 || $nbRecipe !== null) {    
            $queryBuider->setMaxResults($nbRecipe);
    }

    return $queryBuider->getQuery()
        ->getResult()
    ;
    
}
}

