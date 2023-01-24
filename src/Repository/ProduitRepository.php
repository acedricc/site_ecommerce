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

    


//    public function findByTaille($value): array
//    {
//     return $this->createQueryBuilder('p')        
//     ->leftJoin('p', 't',\Doctrine\ORM\Query\Expr\Join::WITH,'p.id = :champ_id' )
//     ->setParameter('champ_id', $champ->getId())
//     ->addSelect('IFNULL(-c.year,0) as HIDDEN year')
//     ->where('t.league=:league_id')      
//     ->setParameter('league_id', $champ->getLeague())
//     ->addorderBy('year')
//     ->addorderBy('t.nom')
//     ->getQuery()
//     ->getResult()
//        ;
//    }

   public function findByTailleField($size): array
   {
    return $this->createQueryBuilder('p')
    ->select('p')
    ->from('*', 'p')
    ->innerJoin('pt ON p.id = pt.produit_id','t ON pt.taille_id=t.id')
    ->where('t.size ="M"')
    ->setParameter('size',$size)
    ->getQuery()
    ->getResult();
   }
   //Creation d'une une methode avec un parametre et une valeur de retour(tableau)
   public function findProductsByGenre($name):array
{
    //on va dans la table produit
    return $this->createQueryBuilder('p')
    // on selectione la table genre
     ->addSelect('g')
       //on join la table produit avec genre 
     ->leftJoin('p.genre', 'g')
   

     ->where('g.type = :type')
     ->setParameter('type', $name)
     ->getQuery()
     ->getResult()
    ; 
}
 
     public function findAllProduitsByTailles($size)
    {
       return $this->createQueryBuilder('p')
        ->leftJoin(Taille::class, "t", Join::WITH, "p.taille = t")
        ->andWhere("t.size = :size")
        ->setParameter("size", $size);
   }    
 
//    public function findByGenre($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->join(Genre::class,'genre.type','g')
//            ->andWhere('genre.type = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//         //    ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }  


}
