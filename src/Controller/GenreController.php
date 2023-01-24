<?php

namespace App\Controller;

use App\Repository\GenreRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    #[Route('/genre/{type}', name: 'app_genre')]
    public function index(ProduitRepository $produitRepository ,$type): Response
    {
        $produitsByGenre = $produitRepository->findProductsByGenre($type);
        
        return $this->render('genre/index.html.twig', [
            'produitsByGenre' => $produitsByGenre,

           
        ]);
    }
}