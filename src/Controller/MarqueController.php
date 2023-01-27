<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarqueController extends AbstractController
{
    #[Route('/marque', name: 'app_marque')]
    public function index(ProduitRepository $produitRepository): Response
    {
        $marques= $produitRepository->findAllMarque();
        return $this->render('marque/index.html.twig', [
            'marques' => $marques
        ]);
    }
}
