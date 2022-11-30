<?php

namespace App\Controller\Admin;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatController extends AbstractController
{
    #[Route('/stat', name: 'app_stat')]

    /**
    * @Route("/admin-statistique", name="app_admin_statistique_show")
    */
    public function index(ProduitRepository $pr, CommandeRepository $cr, UserRepository $userRepository ): Response
    {
    
        $produits = $pr->findAll();
        $compteur = 0;
        foreach ($produits as $prod ) {
            if ($prod->getDetails()->count() > $compteur ) {
                $produitFavori = $prod;
                $compteur = $prod->getDetails()->count();
            }
        }

        $produitFavori = $pr->produitBestSeller()[0]["produit"];
      



        return $this->render('admin/stat/index.html.twig', [
            "users" => $userRepository->findAll(),
            "commandes" => $cr->findAll(),
            "produits" => $produits,
            "produitFavori" => $produitFavori
        ]);
    }
    
}
