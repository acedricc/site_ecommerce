<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    public function index(Request $rq, ProduitRepository $pr): Response
    {
        // Récupération du mot clé de recherche depuis les paramètres de requête
        $mot = $rq->query->get("search");
        // Recherche de produits correspondant au mot clé
        $produitsTrouves = $pr->recherche($mot);
        // Affichage de la page de résultats de recherche
        return $this->render('recherche/index.html.twig', [
            'produits' => $produitsTrouves,
            'mot' => $mot
        ]);
    }
    
    #[Route('/recherche-ajax', name: 'app_recherche_ajax')]
    public function ajax(Request $rq, ProduitRepository $pr): Response
    {
        // Récupération du mot clé de recherche depuis les paramètres de requête
        $mot = $rq->query->get("search");
        // Recherche de produits correspondant au mot clé
        $produitsTrouves = $pr->recherche($mot);
        // Affichage de la page de résultats de recherche en AJAX (chargement dynamique)
        return $this->render('recherche/ajax.html.twig', [
            'produits' => $produitsTrouves,
            'mot' => $mot
        ]);
    }
    
}
