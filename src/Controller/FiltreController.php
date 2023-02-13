<?php

namespace App\Controller;
use App\Repository\TailleRepository;
use App\Repository\GenreRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FiltreController extends AbstractController
{

/**
* @Route("/categorie/{cat}", name="app_produit_categorie")
*/
public function filterByCategorie(ProduitRepository $produitRepository, $cat): Response
{
    $catParents = $produitRepository->findProductsByCat($cat);
    
    return $this->render('filtre/index.html.twig', [
        'listeProduits' =>  $catParents,
    
    ]);
}
/**
* @Route("/genre/{type}", name="app_produit_genre")
*/
public function filterByGenre(TailleRepository $tailleRepository,ProduitRepository $produitRepository ,$type): Response
{
    $listeProduits = $produitRepository->findProductsByGenre($type);
    $tailles =$tailleRepository->findAll();
    $marques = $produitRepository->findAllMarque();
    $couleurs =$produitRepository->findAllCouleur();
    
    return $this->render('filtre/index.html.twig', [
        'listeProduits' => $listeProduits, 
        'tailles' => $tailles,
        'couleurs' => $couleurs,
        'marques' => $marques,
    ]);
}


/**
* @Route("/genre/categorie/{genre}/{cat}", name="app_produit_genre_categorie")
*/
public function filterByGenreAndCat(ProduitRepository $produitRepository,$genre, $cat): Response
{
    $catGenres = $produitRepository->findByGenreAndCat($genre,$cat);
    
    return $this->render('filtre/index.html.twig', [ 
        'listeProduits' =>  $catGenres,
    
    ]);
}

/**
* @Route("/marque/categorie/{mark}/{cat}", name="app_produit_mark_categorie")
*/

public function filterByMarqueAndCat(ProduitRepository $produitRepository,$mark, $cat): Response
{
    $catMarques = $produitRepository->findByMarqueAndCat($mark,$cat);
    // dd( $catMarques);
    return $this->render('filtre/index.html.twig', [ 
        'listeProduits' =>  $catMarques,
    
    ]);
}

/**
* @Route("/taille/categorie/{size}/{cat}", name="app_produit_taille_categorie")
*/
public function filterByTailleAndCat(ProduitRepository $produitRepository,$size, $cat): Response
{
    $catTailles = $produitRepository->findByTailleAndCat($size,$cat);
    dd( $catTailles);
    return $this->render('filtre/index.html.twig', [ 
        'listeProduits' =>  $catTailles,
    
    ]);
}

/**
* @Route("/taille/{size}", name="app_taille")
*/
public function filterTaille(ProduitRepository $produitRepository,$size): Response
{
    $produitTaille = $produitRepository->findByTailleField($size);
     return $this->render('filtre/index.html.twig', [
        'listeProduits' => $produitTaille,
    ]);
}
/**
* @Route("/couleur/{color}", name="app_couleur_color")
*/
public function filterCouleur(ProduitRepository $produitRepository ,$color): Response
{        
    $produitsByCouleurs = $produitRepository->findByCouleur($color);
    $couleurs = $produitRepository->findAllCouleur();
    return $this->render('filtre/couleur/index.html.twig', [
        "listeProduits" => $produitRepository->findAll(),
        'couleurs' => $couleurs,
        'produitsByCouleurs' => $produitsByCouleurs,
    ]);
}
/**
* @Route("/marque/{mark}", name="app_marque_mark")
*/
public function filterByMarque(ProduitRepository $produitRepository,$mark): Response
{
    $produitsByMarques = $produitRepository->findByMarque($mark);
    $marques = $produitRepository->findAllMarque();
    return $this->render('filtre/marque/index.html.twig', [
        'listeProduits' => $produitRepository->findAll(),
        'marques' => $marques,
        'produitsByMarques' => $produitsByMarques,
    ]);
}

}


