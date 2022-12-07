<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TailleController extends AbstractController
{
    #[Route('/taille', name: 'app_taille')]
    public function taille(ProduitRepository $produitRepository , $taille): Response
    {
        $tailles = $produitRepository->findByTailleField($taille);

        return $this->render('taille/index.html.twig', [
            'tailles' => $tailles,
        ]);
    }
}
