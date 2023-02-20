<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use App\Repository\TailleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
   
    public function index(TailleRepository $tailleRepository,ProduitRepository $produitRepository ): Response
    {
      
        $listeProduits = $produitRepository->findAll();
        $tailles =  $tailleRepository->findAll();
        $marques = $produitRepository->findAllMarque();
        $couleurs =$produitRepository->findAllCouleur();
        // $size =$produitRepository->findAllProduitsByTailles('M');
        // dd($tailles);
        return $this->render('home/index.html.twig', [       
           'listeProduits' => $listeProduits,
           'tailles' => $tailles,
           'couleurs' => $couleurs,
           'marques' => $marques,
          
        
           
        ]);
    }
}