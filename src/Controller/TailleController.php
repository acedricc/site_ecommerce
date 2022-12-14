<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TailleController extends AbstractController
{
    #[Route('/taille/{tail}', name: 'app_taille_tail')]
    public function taille(ProduitRepository $produitRepository , $tail): Response
    {
        // dd($tailles);
        $produitsByTail = $produitRepository->findByTailleField($tail);
        $tailles = $produitRepository->findAllTaille();

        return $this->render('taille/index.html.twig', [
            "listeProduits" => $produitRepository->findAll(),
            'tailles' => $tailles,
            'produitsByTail' => $produitsByTail,
        ]);
    }

}
