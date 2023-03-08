<?php


namespace App\Controller;

use App\Entity\Produit;
use App\Repository\TailleRepository;
use App\Repository\GenreRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FiltreController extends AbstractController
{

//////////////////////////FILTRE POUR TRIER PAR GENRE///////////////////////////////////////////////////////
/**
 * @Route("/genre/{genre}", name="app_produit_genre")
 */
public function filterByGenre(ProduitRepository $produitRepository ,$genre): Response
{
    // Appelle la méthode "findByMultipleAttributes" du repository de l'entité "Produit"
    // en lui passant en argument la variable "$genre", qui correspond à la valeur de l'attribut "genre" sélectionné.
    // Cette méthode permet de trouver tous les produits qui correspondent au genre sélectionné.
    $listeProduits = $produitRepository->findByMultipleAttributes($genre);
    
    // Renvoie une vue Twig avec la liste des produits trouvés dans la méthode précédente.
    // Le fichier Twig utilisé est "filtre/index.html.twig".
    // La liste des produits est transmise à la vue sous la forme d'une variable "listeProduits".
    return $this->render('filtre/index.html.twig', [
        'listeProduits' => $listeProduits, 
    ]);
}




//////////////////////////FILTRE POUR TRIER PAR CATEGORIE///////////////////////////////////////////////////////
/**
* @Route("/categorie/{parent}", name="app_produit_categorie")
*/
public function filterByCategorie(ProduitRepository $produitRepository,$parent): Response
{
    $catParents = $produitRepository->findByMultipleAttributes(null, null, null, null, null, $parent);
    
    return $this->render('filtre/index.html.twig', [
        'listeProduits' =>  $catParents,    
    ]);
}


/**
* @Route("/categorie/acces/{cat}", name="app_produit_categoriev2")
*/
public function filterByCategoriev2(ProduitRepository $produitRepository,$cat): Response
{
    $catParents = $produitRepository->findByMultipleAttributes(null, $cat);
    
    return $this->render('filtre/index.html.twig', [
        'listeProduits' =>  $catParents,
    
    ]);
}


//////////////////////////FILTRE POUR TRIER PAR TAILLE///////////////////////////////////////////////////////
/**
* @Route("/taille/{size}", name="app_taille")
*/
public function filterTaille(ProduitRepository $produitRepository,$size): Response
{
    $produitTaille = $produitRepository->findByMultipleAttributes(null, null, $size);


     return $this->render('filtre/index.html.twig', [
        'listeProduits' => $produitTaille,
        
    ]);
}
//////////////////////////FILTRE POUR TRIER PAR MARQUE///////////////////////////////////////////////////////

/**
* @Route("/marque/{mark}", name="app_marque_mark")
*/
public function filterByMarque(ProduitRepository $produitRepository,$mark): Response
{
    $produitsByMarques = $produitRepository->findByMultipleAttributes(null, null, null, $mark);
    
    return $this->render('filtre/index.html.twig', [        
        'listeProduits' => $produitsByMarques,
    ]);
}
//////////////////////////FILTRE POUR TRIER PAR COULEUR///////////////////////////////////////////////////////
/**
* @Route("/couleur/{color}", name="app_couleur_color")
*/
public function filterCouleur(ProduitRepository $produitRepository ,$color): Response
{        
    $produitsByCouleurs = $produitRepository->findByMultipleAttributes(null, null, null, null, $color);
    
    return $this->render('filtre/index.html.twig', [
        'listeProduits' => $produitsByCouleurs,
    ]);
}


//////////////////////////FILTRE POUR TRIER PAR GENRE & CATEGORIE///////////////////////////////////////////////////////
/**
* @Route("/genre/categorie/{genre}/{parent}", name="app_produit_genre_categorie")
*/
public function filterByGenreAndCat(ProduitRepository $produitRepository,$genre, $parent): Response
{
    $catGenres = $produitRepository->findByMultipleAttributes($genre, null, null, null, null, $parent);
    
    return $this->render('filtre/index.html.twig', [ 
        'listeProduits' =>  $catGenres,
    
    ]);
}

public function supprimerSiStockNul(ProduitRepository $produitRepository,int $produitId): Response
{
    $this->$produitRepository->supprimerProduitSiStockNul($produitId);
    return $this->render('filtre/index.html.twig', [ 
       
        
    ]);


}
}


