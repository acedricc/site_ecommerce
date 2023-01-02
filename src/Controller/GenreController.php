<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    #[Route('/genre/{genre}', name: 'app_genre')]
    public function index(ProduitRepository $produitRepository , $genre): Response
    {
        $produitsByGenre = $produitRepository->findByGenre($genre);
        $tailles =$produitRepository->findAllTaille();
 
        return $this->render('genre/index.html.twig', [
            'produitsByGenre' => $produitsByGenre,
            'tailles' => $tailles,
        ]);
    }
}
