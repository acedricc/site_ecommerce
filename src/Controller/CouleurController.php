<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CouleurController extends AbstractController
{
    #[Route('/couleur/{color}', name: 'app_couleur_color')]
    public function index(ProduitRepository $produitRepository , $color): Response
    {        
        $produitsByCouleurs = $produitRepository->findByCouleur($color);
        $couleurs = $produitRepository->findAllCouleur();

        return $this->render('couleur/index.html.twig', [
            "listeProduits" => $produitRepository->findAll(),
            'couleurs' => $couleurs,
            'produitsByCouleurs' => $produitsByCouleurs,
        ]);
    }

}