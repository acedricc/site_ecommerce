<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie/{cat}', name: 'app_categorie_cat')]
    public function catFilter(ProduitRepository $produitRepository , $cat ): Response
    {
        $cats = $produitRepository->findByCategorieField($cat);
        
        $tailles = $produitRepository->findAllTaille();

        $produitsByGenres = $produitRepository->findAllGenre();

        // $tailleCategories =$produitRepository->findByTailleField($tailleCategorie);

        // dd($cats);
        return $this->render('categorie/index.html.twig', [
            'cats' => $cats,
            'tailles' => $tailles,
            'produitsByGenres' => $produitsByGenres,
            // 'tailleCategories' => $tailleCategories
        ]);
    }

}

