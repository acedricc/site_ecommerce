<?php

namespace App\Repository;

use App\Entity\Detail;
use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 *
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function save(Produit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Produit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function recherche($value): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.titre LIKE :val')
            ->setParameter('val', "%$value%")
            ->orderBy('p.titre', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function produitBestSeller()
    {
        return $this->createQueryBuilder("p")
            ->join(Detail::class,"d","WITH", "p.id = d.produit")
            ->groupBy("p.id")
            ->select("p as produit", "count(d) as nb")
            ->orderBy("nb", "DESC")
            // ->setMaxResults(1)
            ->getQuery()
            ->getResult();
            
    }
    public function produitStock()
{
    return $this->createQueryBuilder("p")
    ->where("p.stock < 10")
    ->orderBy("p.titre")
    ->getQuery()
    ->getResult();

}

   /**
    * @return Produit[] Returns an array of Produit objects
    */
   public function findByCategorieField($value): array
   {
       return $this->createQueryBuilder('p')
           ->andWhere('p.categorie = :val')
           ->setParameter('val', $value)
           ->orderBy('p.id', 'ASC')
        //    ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

   public function findByTailleField($value): array
   {
       return $this->createQueryBuilder('p')
           ->andWhere('p.taille = :val')
           ->setParameter('val', $value)
           ->orderBy('p.id', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }   
   public function findAllTaille(): array
   {
       return $this->createQueryBuilder('p')
            ->select('p.taille')
            ->distinct()
           ->orderBy('p.taille', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }    
   
   public function findByGenre($value): array
   {
       return $this->createQueryBuilder('p')
           ->andWhere('p.genre = :val')
           ->setParameter('val', $value)
           ->orderBy('p.id', 'ASC')
        //    ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }  

   public function findAllGenre(): array
   {
       return $this->createQueryBuilder('p')
            ->select('p.genre')
            ->distinct()
           ->orderBy('p.genre', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }  

   
//    public function findOneBySomeField($value): ?Produit
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
