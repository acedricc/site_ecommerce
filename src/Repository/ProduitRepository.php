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
        // Crée une requête à partir du QueryBuilder, en partant de l'entité "p" (produit)
        // et en cherchant tous les produits qui correspondent à la valeur de recherche donnée.
        return $this->createQueryBuilder('p')
            // La clause WHERE permet de filtrer les produits en fonction de critères spécifiques. 
            // Ici, on recherche des produits dont le titre, la couleur, la marque, la description 
            // ou le nom de la catégorie correspondent à la valeur de recherche.
            ->where('p.titre LIKE :val OR p.couleur LIKE :val OR p.marque LIKE :val OR p.description LIKE :val  OR c.nom LIKE :val  ')
            // La méthode leftJoin() permet de rejoindre la table de la catégorie ("c") à la table des produits ("p").
            ->leftJoin('p.categorie', 'c')
            // La méthode setParameter() permet de définir la valeur de la variable :val dans la requête.
            // Cette variable correspond à la valeur de recherche passée en paramètre de la fonction.
            ->setParameter('val', "%$value%")
            // La méthode orderBy() permet de trier les produits en fonction de leur titre, par ordre croissant.
            ->orderBy('p.titre', 'ASC')
            // La méthode getQuery() renvoie l'objet Query généré à partir de la requête construite.
            ->getQuery()
            // La méthode getResult() exécute la requête et renvoie un tableau de résultats.
            ->getResult();
    }
    
    public function produitBestSeller()
    {
        // Crée une requête à partir du QueryBuilder, en partant de l'entité "p" (produit).
        // Cette requête permet de trouver les produits les plus vendus.
        return $this->createQueryBuilder("p")
            // La méthode join() permet de joindre la table des détails de commande ("d") à la table des produits ("p").
            // La condition "WITH p.id = d.produit" permet de lier les deux tables en fonction de l'identifiant du produit.
            ->join(Detail::class,"d","WITH", "p.id = d.produit")
            // La méthode groupBy() permet de regrouper les résultats par produit, afin de pouvoir compter le nombre de ventes.
            ->groupBy("p.id")
            // La méthode select() permet de sélectionner les colonnes à afficher dans la requête.
            // Ici, on affiche le produit lui-même et le nombre de détails de commande correspondants.
            ->select("p as produit", "count(d) as nb")
            // La méthode orderBy() permet de trier les produits en fonction de leur nombre de ventes, par ordre décroissant.
            ->orderBy("nb", "DESC")
            // La méthode setMaxResults() permet de limiter le nombre de résultats renvoyés par la requête.
            // Ici, la limite est commentée, ce qui signifie que tous les produits sont renvoyés.
            // ->setMaxResults(1)
            // La méthode getQuery() renvoie l'objet Query généré à partir de la requête construite.
            ->getQuery()
            // La méthode getResult() exécute la requête et renvoie un tableau de résultats.
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

public function findContentField($value): array
{
    // Crée une requête à partir du QueryBuilder, en partant de l'entité "p" (produit).
    // Cette requête permet de trouver les valeurs distinctes d'un champ spécifié ("$value") de la table des produits.
    return $this->createQueryBuilder('p')
        // La méthode select() permet de sélectionner le champ à afficher dans la requête.
        // Ici, on sélectionne le champ spécifié par la variable "$value".
        ->select('p.'.$value)
        // La méthode distinct() permet de ne sélectionner que les valeurs distinctes du champ sélectionné.
        ->distinct()
        // La méthode orderBy() permet de trier les résultats par ordre croissant en fonction du champ sélectionné.
        ->orderBy('p.'.$value, 'ASC')
        // La méthode getQuery() renvoie l'objet Query généré à partir de la requête construite.
        ->getQuery()
        // La méthode getScalarResult() exécute la requête et renvoie un tableau de résultats sous forme de tableaux associatifs.
        // Chaque tableau associatif contient une seule clé, correspondant au champ sélectionné.
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

public function findByMultipleAttributes($genre = null, $cat = null, $size = null, $mark = null, $color = null, $parent = null) :array
{
    // Initialise une instance de QueryBuilder avec la table des produits
    $query = $this->createQueryBuilder('p');

    // Si un genre est fourni, effectue une jointure avec la table des genres et ajoute une clause WHERE pour filtrer par type de genre
    if (!empty($genre) ) {
        $query->addSelect('g')
        ->leftJoin('p.genre', 'g')     
        ->andWhere('g.type = :type')
        ->setParameter('type', $genre);
    }
   
    // Si une catégorie est fournie, effectue une jointure avec la table des catégories et ajoute une clause WHERE pour filtrer par nom de catégorie
    if (!empty($cat) ) {
        $query->addSelect('c')
        ->join('p.categorie', 'c')
        ->andWhere('c.nom = :nom')
        ->setParameter('nom', $cat);
    }
  // Si une taille est fournie, effectue une jointure avec la table des tailles et ajoute une clause WHERE pour filtrer par taille
if (!empty($size)) {
    $query->addSelect('t')
   ->leftJoin('p.taille','t')
   ->andWhere('t.size = :size')
   ->setParameter('size' , $size);  
}
// Si une marque est fournie, ajoute une clause WHERE pour filtrer par marque
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
   
if (!empty($parent) ) {
    $query->addSelect('c')
    ->join('p.categorie', 'c')
    ->andWhere('c.parent = :parent')
    ->setParameter('parent', $parent);
}
  
    return $query->getQuery()
                ->getResult(); 
}


// public function supprimerProduitSiStockNul(int $produitId): void
// {
//     // Récupérer le produit correspondant à l'identifiant passé en paramètre
//     $produit = $this->find($produitId);
//     dd($produit);

//     // Vérifier si le produit existe et que son stock est nul ou négatif
//     if ($produit && $produit->getStock() <= 0) {
//         // Récupérer le gestionnaire d'entités
//         $entityManager = $this->getEntityManager();

//         // Supprimer le produit en utilisant le gestionnaire d'entités
//         $entityManager->remove($produit);

//         // Sauvegarder les modifications dans la base de données
//         $entityManager->flush();
//     }
// }
// public function supprimerProduitSiStockNul2(int $produitId): void
// {
//     // Récupérer le produit correspondant à l'identifiant passé en paramètre
//     $produit = $this->find($produitId);

//     if (!$produit) {
//         throw new \InvalidArgumentException(sprintf('Produit avec l\'identifiant %d non trouvé.', $produitId));
//     }

//     // Vérifier si le stock du produit est nul ou négatif
//     if ($produit->getStock() <= 0) {
//         // Récupérer le gestionnaire d'entités
//         $entityManager = $this->getEntityManager();

//         // Supprimer le produit en utilisant le gestionnaire d'entités
//         $entityManager->remove($produit);

//         // Sauvegarder les modifications dans la base de données
//         $entityManager->flush();
//     } else {
//         throw new \InvalidArgumentException(sprintf('Le produit avec l\'identifiant %d a un stock positif.', $produitId));
//     }
// }
}

