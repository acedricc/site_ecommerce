<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FiltreController extends AbstractController
{
    #[Route('/filtre', name: 'app_filtre')]
    public function index(): Response
    {
        return $this->render('filtre/index.html.twig', [
            'controller_name' => 'FiltreController',
        ]);
    }

    /**
    * @Route("/categorie/{cat}", name="app_produit_categorie")
    */
    // public function index(ProduitRepository $produitRepository, $cat): Response
    // {
    //     $catParents = $produitRepository->findProductsByCat($cat);
        
    //     return $this->render('categorie/index.html.twig', [
    //         'controller_name' => 'CategorieController',
    //         'catParents' =>  $catParents,
        
    //     ]);
    // }
}
