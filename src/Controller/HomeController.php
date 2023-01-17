<?php

namespace App\Controller;

use App\Repository\TailleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
   
    public function index(TailleRepository $tailleRepository,$size): Response
    {
        
        $produitSize =$tailleRepository->findByTailleField($size);
        // dd($tailles);
        return $this->render('home/index.html.twig', [
        
           'produitSizes' => $produitSize
        ]);
    }
}