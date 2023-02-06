<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/produit")
*/
class ProduitController extends AbstractController
{
    /**
    * @Route("/fiche-produit-{id}", name="app_produit_show")
    */

public function showFiche(Produit $produit): Response
{
    $details = $produit->getDetails();
    $nb = 0;
    foreach($details as $d){
        $nb += $d->getQuantite();
    }
    return $this->render('produit/fiche_produit.html.twig', [
        'produit' => $produit,
        "nb" => $nb
    ]);
}
/**
* @Route("/categorie/{cat}", name="app_produit_categorie")
*/
public function filterByCategorie(ProduitRepository $produitRepository, $cat): Response
{
    $catParents = $produitRepository->findProductsByCat($cat);
    
    return $this->render('categorie/index.html.twig', [
        'controller_name' => 'CategorieController',
        'catParents' =>  $catParents,
    
    ]);
}
/**
* @Route("/genre/categorie/{genre}/{cat}", name="app_produit_genre_categorie")
*/
public function filterByGenreAndCat(ProduitRepository $produitRepository,$genre, $cat): Response
{
    $catParents = $produitRepository->findByGenreAndCat($genre,$cat);
    
    return $this->render('filtre/index.html.twig', [
        'produitsFiltre' =>  $catParents,
    
    ]);
}


}
