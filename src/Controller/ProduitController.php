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

}
