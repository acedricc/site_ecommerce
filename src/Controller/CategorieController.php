<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie{cat}', name: 'app_categorie')]
    public function index(CategorieRepository $categorieRepository,ProduitRepository $produitRepository, $cat): Response
    {
        $listeProduits = $produitRepository->findAll();
        $produitsByCat= $categorieRepository->findByCategorieNomField($cat);
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'produitsByCat' =>  $produitsByCat,
            'listeProduits' => $listeProduits
        ]);
    }
}
