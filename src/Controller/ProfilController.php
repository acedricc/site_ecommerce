<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }
    /**
     * @Route("/liste-produits", name="app_profil_liste")
     */
    public function liste(ProduitRepository $produitRepository): Response
    {
        return $this->render("profil/liste_produits.html.twig", [ 
            "produits" => $produitRepository->findAll() 
        ]);
    }
     /**
     * @route("/detail-commande-{id}", name="app_profil_commande", requirements={"id"="\d+"})
     */

    public function detailCommande(Commande $commande): Response{
        if( $commande->getUser() == $this->getUser()){
                   return $this->render("profil/detail_commande.html.twig", [
            "commande" => $commande
        ]); 
        }
        throw $this->createAccessDeniedException("Vous n'avez pas accès à cet URL");
    }
}
