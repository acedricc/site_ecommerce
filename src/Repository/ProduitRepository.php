<?php

namespace App\Repository;

use App\Entity\Detail;
use App\Entity\Produit;
use App\Entity\Taille;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr;
use Proxies\__CG__\App\Entity\Genre;

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
            ->where('p.titre LIKE :val OR p.couleur LIKE :val OR p.marque LIKE :val OR p.description LIKE :val  OR c.nom LIKE :val  ')
            ->leftJoin('p.categorie', 'c')
            // ->leftJoin('p.taille', 't')  
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

public function findAllCouleur(): array
{
    return $this->createQueryBuilder('p')
         ->select('p.couleur')
         ->distinct()
        ->orderBy('p.couleur', 'ASC')
        ->getQuery()
        ->getScalarResult()
    ;
} 

public function findAllMarque(): array
{
    return $this->createQueryBuilder('p')
         ->select('p.marque')
         ->distinct()
        ->orderBy('p.marque', 'ASC')
        ->getQuery()
        ->getScalarResult()
    ;
} 


   /**
    * @return Produit[] Returns an array of Produit objects
    */



//    public function findOneBySomeField($value): ?Produit
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function findByMultipleAttributes($genre = null, $cat = null, $size = null, $mark = null, $color = null) :array
{
    
    $query = $this->createQueryBuilder('p');

    if (!empty($genre) ) {
        $query->addSelect('g')
        ->leftJoin('p.genre', 'g')     
        ->andWhere('g.type = :type')
        ->setParameter('type', $genre);
    }
   
    if (!empty($cat) ) {
        $query->addSelect('c')
        ->leftJoin('p.categorie', 'c')     
        ->where('c.nom = :cat')
        ->setParameter('cat', $cat);
    }
  
if (!empty($size)) {
    $query->addSelect('t')
    ->leftJoin('p.taille', 't') 
    ->addSelect('tp')
    ->leftJoin('t.taille', 't')     
    ->where('t.size = :size')
    ->setParameter('size', $size)  
    ->where('t.size = :size')
    ->setParameter('size', $size);
  
}

if (!empty($mark)) {
    $query->addSelect('p')
    ->andWhere('p.marque = :marque')
    ->setParameter('marque', $mark);
  
}
if (!empty($color)) {
    $query->addSelect('p')
    ->andWhere('p.couleur = :couleur')
    ->setParameter('couleur', $color);
  
}
  
    return $query->getQuery()
                ->getResult(); 
}
// public function findByProductIdAndSize($productId, $size): array
// {
//     $sql = "SELECT * FROM produit_taille pt
//             LEFT JOIN produit p ON pt.produit_id = p.id
//             LEFT JOIN taille t ON pt.taille_id = t.id 
//             WHERE p.id = :productId 
//             AND t.size = :size";

//     $query = $this->getEntityManager()->createNativeQuery($sql, new ResultSetMappingBuilder($this->getEntityManager()));
//     $query->setParameter('productId', $productId);
//     $query->setParameter('size', $size);

//     return $query->getResult();
// }

public function findByTailleAndGenre( $genre, $size )
{
   $query = $this->createQueryBuilder('p');

   $query->addSelect('g')
   ->leftJoin('p.genre','g')
   ->where('g.type = :genre')
   ->setParameter('genre' ,$genre)
   ->addSelect('t')
   ->leftJoin('p.taille','t')
   ->where('t.size = :size')
   ->setParameter('size' ,$size);
    return $query->getQuery()
    ->getResult();
}
public function findProductsByParentCategory($parent)
{
    $query = $this->createQueryBuilder('p');
    
    $query->addSelect('c')
        ->join('p.categorie', 'c')
        ->where('c.parent = :parent')
        ->setParameter('parent', $parent);
    return $query->getQuery()->getResult();
}


}

