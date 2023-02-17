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
//////////////////////////FILTRE POUR TRIER PAR GENRE///////////////////////////////////////////////////////
/**
* @Route("/genre/{genre}", name="app_produit_genre")
*/
public function filterByGenre(TailleRepository $tailleRepository,ProduitRepository $produitRepository ,$genre): Response
{
    $listeProduits = $produitRepository->findByMultipleAttributes($genre, null, null, null, null);
    // $tailles =$tailleRepository->findAll();
    // $marques = $produitRepository->findAllMarque();
    // $couleurs =$produitRepository->findAllCouleur();
    // dd($listeProduits);
    return $this->render('filtre/index.html.twig', [
        'listeProduits' => $listeProduits, 
        // 'tailles' => $tailles,
        // 'couleurs' => $couleurs,
        // 'marques' => $marques,
    ]);
}
//////////////////////////FILTRE POUR TRIER PAR CATEGORIE///////////////////////////////////////////////////////
/**
* @Route("/categorie/{parent}", name="app_produit_categorie")
*/
public function filterByCategorie(ProduitRepository $produitRepository,$parent = 2): Response
{
    $catParents = $produitRepository->findProductsByParentCategory($parent);
    
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
    $produitTaille = $produitRepository->findByMultipleAttributes(null, null, $size, null, null);
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
    $produitsByMarques = $produitRepository->findByMultipleAttributes(null, null, null, $mark, null);
    // $marques = $produitRepository->findAllMarque();
    return $this->render('filtre/index.html.twig', [
        // 'listeProduits' => $produitRepository->findAll(),
        // 'marques' => $marques,
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
    // $couleurs = $produitRepository->findAllCouleur();
    return $this->render('filtre/index.html.twig', [
        // "listeProduits" => $produitRepository->findAll(),
        // 'couleurs' => $couleurs,
        'listeProduits' => $produitsByCouleurs,
    ]);
}

//////////////////////////FILTRE POUR TRIER PAR GENRE & CATEGORIE///////////////////////////////////////////////////////
/**
* @Route("/genre/categorie/{genre}/{cat}", name="app_produit_genre_categorie")
*/
public function filterByGenreAndCat(ProduitRepository $produitRepository,$genre, $cat): Response
{
    $catGenres = $produitRepository->findByMultipleAttributes($genre, $cat);
    
    return $this->render('filtre/index.html.twig', [ 
        'listeProduits' =>  $catGenres,
    
    ]);
}

//////////////////////////FILTRE POUR TRIER PAR GENRE & TAILLE///////////////////////////////////////////////////////
/**
* @Route("/genre/taille/{genre}/{size}", name="app_produit_genre_taille")
*/
public function findByProductIdAndSize(ProduitRepository $produitRepository,TailleRepository $tr,$genre, $size): Response
{
    $catTailles = $tr->findByTailleAndGenre(2);
    dd( $catTailles);
    return $this->render('filtre/index.html.twig', [ 
        'listeProduits' =>  $catTailles,
    
    ]);
}

//////////////////////////FILTRE POUR TRIER PAR GENRE & MARQUE///////////////////////////////////////////////////////

// public function filterByGenreAndTaille(ProduitRepository $produitRepository,$genre, $size): Response
// {
//     $produitsByGenreAndMarque = $produitRepository->findByMultipleAttributes($genre,  $size);
//     dd( $catTailles);
//     return $this->render('filtre/index.html.twig', [ 
//         'listeProduits' =>  $catTailles,
    
//     ]);
// }


/**
* @Route("/genre/categorie/{genre}/{mark}/{cat}", name="app_produit_mark_categorie")
*/

public function filterByMarqueAndCat(ProduitRepository $produitRepository, $genre, $mark, $cat): Response
{
    $catMarques = $produitRepository->findByMultipleAttributes($genre, $cat, null, $mark);
    // dd( $catMarques);
    return $this->render('filtre/index.html.twig', [ 
        'listeProduits' =>  $catMarques,
    
    ]);
}






}



