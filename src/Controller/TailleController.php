<?php

namespace App\Controller;

use App\Entity\Taille;
use App\Repository\ProduitRepository;
use App\Repository\TailleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TailleController extends AbstractController
{
    #[Route('/taille/{size}', name: 'app_taille')]
    public function index(ProduitRepository $produitRepository, $size): Response
    {
        $produitTaille = $produitRepository->findTaille($size);

         return $this->render('taille/index.html.twig', [
            'tailles' => $produitTaille,
        ]);
    }
}