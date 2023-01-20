<?php

namespace App\Controller;

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
        $tailles =$tailleRepository->findAll();
        // $size =$produitRepository->findAllProduitsByTailles('M');
        // dd($size);
        return $this->render('home/index.html.twig', [
        
           'tailles' => $tailles,
           'listeProduits' => $listeProduits 

        ]);
    }
}