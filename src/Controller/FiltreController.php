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
    $listeProduits = $produitRepository->findByMultipleAttributes($genre);
    
    return $this->render('filtre/index.html.twig', [
        'listeProduits' => $listeProduits, 
    ]);

   
    
}

public function supprimerProduit(Produit $produit)
{
    $stock = $produit->getStock();
    $produitRepository = $this->getDoctrine()->getRepository(Produit::class);
    $produitRepository->supprimerProduitSiStockNul($produit, $stock);
    
    return new Response('Produit supprimé avec succès.');
}

public function show(Produit $produit, ProduitRepository $produitRepository): Response
{
    $stock = $produit->getStock();
    $produitRepository->supprimerProduitSiStockNul($stock, $produit);

    // Le produit sera supprimé si le stock est inférieur ou égal à zéro.

    return $this->render('produit/fiche_produit.html.twig', [
        'produit' => $produit,
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

//////////////////////////FILTRE POUR TRIER PAR GENRE & TAILLE///////////////////////////////////////////////////////
/**
* @Route("/genre/taille/{genre}/{size}", name="app_produit_genre_taille")
*/
public function findByProductIdAndSize(ProduitRepository $produitRepository,$genre, $size): Response
{
    $catTailles = $produitRepository->findByTailleAndGenre([$genre, $size]);
    dd( $catTailles);
    return $this->render('filtre/index.html.twig', [ 
        'listeProduits' =>  $catTailles,
    
    ]);
}

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



