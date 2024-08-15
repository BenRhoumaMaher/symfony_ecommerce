<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function searchEngine(string $query): array
    {
        // Start building the query using the createQueryBuilder method.
        $qb = $this->createQueryBuilder('p');

        // Add conditions to the query to match the entity's name or description against the query string.
        $qb->where('p.name LIKE :query')
            ->orWhere('p.description LIKE :query');

        // Set the parameter value for ':query' placeholder in the query.
        $qb->setParameter('query', '%' . $query . '%'); // Note: Added '%' around $query to support partial matches.

        // Execute the query and get the result.
        $result = $qb->getQuery()->getResult();

        // Return the result as an array.
        return $result;
    }


    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    // public function findByIdUp($value): array
    // {
    //     return $this->createQueryBuilder('p')
    //         ->andWhere('p.id = :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('p.id', 'DESC')
    //         // ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult();
    // }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
