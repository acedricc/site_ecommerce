<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie/{cat}', name: 'app_categorie')]
    public function index(ProduitRepository $produitRepository, $cat): Response
    {
       
        $catParents = $produitRepository->findProductsByCat($cat);
        // dd($catParents);
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'catParents' =>  $catParents,
        
        ]);
    }
}
