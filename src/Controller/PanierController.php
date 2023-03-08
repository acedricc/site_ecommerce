<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Detail;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/panier')]
class PanierController extends AbstractController
{
    #[Route('/', name: 'app_panier')] // attribue une route à la méthode
    public function index(Session $session): Response // déclare une méthode qui prend en paramètre un objet Session et retourne une instance de la classe Response
    {
        $panier = $session->get("panier", []); // récupère le contenu du panier stocké dans la session de l'utilisateur ou un tableau vide si le panier est vide
        return $this->render('panier/index.html.twig', [ // génère une réponse HTTP contenant le rendu de la vue Twig 'panier/index.html.twig' avec les variables 'panier' et 'total'
            'panier' => $panier, // transmet le contenu du panier à la vue
        ]);
    }
    

// On définit la route avec un paramètre 'id' qui doit être un entier
#[Route('/ajouter-produit-{id}', name: 'app_panier_ajouter' , requirements:["id"=>"\d+"])]
public function ajouter($id, ProduitRepository $pr, Session $session, Request $rq)
{
    // On récupère la quantité passée en paramètre de la requête, ou on utilise 1 si elle n'est pas définie
    $quantite = $rq->query->get("qte", 1) ?: 1;
    // On récupère le produit correspondant à l'ID passé en paramètre
    $produit = $pr->find($id);
    // On récupère ce qu'il y a dans le panier en session, ou un tableau vide si le panier n'a pas encore été initialisé
    $panier = $session->get("panier", []);

    // On vérifie si le produit est déjà dans le panier
    $produitDejaDansPanier = false;
    foreach ($panier as $indice => $ligne) {
        if ($produit->getId() == $ligne["produit"]->getId()) {
            // Si le produit est déjà dans le panier, on ajoute simplement la quantité passée en paramètre à la quantité existante
            $panier[$indice]["quantite"] += $quantite;
            $produitDejaDansPanier = true;
            break;  // Pour sortir de la boucle foreach une fois que le produit a été trouvé
        }
    }
    // Si le produit n'est pas encore dans le panier, on ajoute une nouvelle ligne au panier
    if (!$produitDejaDansPanier) {
        $panier[] = ["quantite" => $quantite, "produit" => $produit];  // On ajoute une ligne au panier => $panier est un array d'array
    }

    // On met à jour le panier en session avec le nouveau contenu
    $session->set("panier", $panier);

    // On calcule le nombre total de produits dans le panier
    $nb = 0;
    foreach ($panier as $ligne){
        $nb += $ligne["quantite"];
    }

    // On retourne une réponse JSON contenant le nombre total de produits dans le panier
    return $this->json($nb);
}

#[Route('/vider', name: 'app_panier_vider')]

public function vider(Session $session)
{
    $session->remove("panier");
    return $this->redirectToRoute("app_panier");
}

#[Route('/supprimer-produit-{id}', name: 'app_panier_supprimer',requirements:["id"=>"\d+"])]
public function supprimer(Produit $produit, Session $session)
{
// On récupère le panier enregistré en session
$panier = $session->get("panier", []);
// On parcourt le panier pour trouver la ligne correspondante au produit à supprimer
foreach ($panier as $indice => $ligne) {
    if ($ligne['produit']->getId() == $produit->getId()) {
        // Si la ligne correspond au produit, on la supprime du panier
        unset($panier[$indice]);
        break;
    }
}

// On enregistre le nouveau panier en session
$session->set("panier", $panier);

// On redirige l'utilisateur vers la page du panier
return $this->redirectToRoute("app_panier");
}
#[Route('/valider', name: 'app_panier_valider')] // Définit la route pour cette fonction dans le contrôleur
#[IsGranted('ROLE_CLIENT')] // Définit que l'utilisateur doit avoir le rôle 'ROLE_CLIENT' pour accéder à cette fonction
public function valider(Session $session, ProduitRepository $produitRepository, EntityManagerInterface $em)
{
    $panier = $session->get("panier", []); // Récupère le contenu du panier depuis la session, ou un tableau vide si le panier n'existe pas
    if ($panier) { // Si le panier n'est pas vide
        $cmd = new Commande; // Crée une nouvelle instance de la classe Commande
        $cmd->setDateEnregistrement(new DateTime()); // Définit la date d'enregistrement de la commande à la date et l'heure actuelles
        $cmd->setEtat("en Attente"); // Définit l'état de la commande à "en attente"
        $cmd->setUser($this->getUser()); // Associe l'utilisateur connecté à la propriété 'client' de la commande
        
        $montant = 0; // Initialise le montant total de la commande à zéro
        
        // Boucle sur chaque ligne du panier
        foreach ($panier as $ligne) {
            // Récupère le produit en base de données en utilisant l'ID stocké dans la ligne du panier
            $produit = $produitRepository->find($ligne["produit"]->getId());
            
            // Calcule le montant de la ligne en multipliant le prix du produit par la quantité commandée
            $montant += $produit->getPrix() * $ligne["quantite"];

            // Crée une nouvelle instance de la classe Detail pour enregistrer les détails de la ligne de commande
            $detail = new Detail;
            $detail->setPrix($produit->getPrix()); // Définit le prix unitaire de la ligne
            $detail->setQuantite($ligne["quantite"]); // Définit la quantité commandée
            $detail->setProduit($produit); // Associe le produit à la ligne de commande
            $detail->setCommande($cmd); // Associe la commande à la ligne de commande
            $em->persist($detail); // Ajoute l'objet $detail à la liste des objets à persister en base de données
            
            // Met à jour le stock du produit en soustrayant la quantité commandée
            $produit->setStock($produit->getStock() - $ligne["quantite"]);
        }
        
        $cmd->setMontant($montant); // Définit le montant total de la commande
        $em->persist($cmd); // Ajoute l'objet $cmd à la liste des objets à persister en base de données
        $em->flush(); // Exécute toutes les requêtes en attente (INSERT INTO)
        
        $session->remove("panier"); // Supprime le panier de la session
        $this->addFlash("success", "Votre commande a été enregistrée"); // Ajoute un message de succès à afficher à l'utilisateur
        return $this->redirectToRoute("app_panier"); // Redirige l'utilisateur vers la page du panier
    }
    
    $this->addFlash("danger", "Le panier est vide. Vous ne pouvez pas valider la commande.");
    return $this->redirectToRoute("app_panier");
}

/**
 * @Route("/ajouter-produit-card-{id}", name="app_panier_ajouter_card", requirements={"id"="\d+"})
 */
public function ajouterCard($id, ProduitRepository $pr, Session $session, Request $rq)
{        
    // Récupération des paramètres passés dans l'URL
    $quantite = $rq->query->get("qte");        
    $nouveauPrixTotal = $rq->query->get("nouveauPrixTotal");        
    // Récupération du produit correspondant à l'identifiant passé en paramètre
    $produit = $pr->find($id);
    // Récupération du panier stocké en session ou création d'un panier vide
    $panier = $session->get("panier", []);
    $nb = 0;
    $prixTotal = 0;

    // Parcours des lignes du panier pour vérifier si le produit à ajouter est déjà présent
    foreach ($panier as $indice => $ligne) {
        if ($produit->getId() == $ligne["produit"]->getId()) {
            // Si le produit est déjà présent, on ajoute la quantité passée en paramètre à la quantité existante
            $panier[$indice]["quantite"] += $quantite;
            // On récupère la quantité totale de ce produit dans le panier
            $nb = $panier[$indice]["quantite"];
            // Pas besoin de continuer à parcourir le panier, on sort de la boucle foreach
            // break;  
        }
        // Calcul du prix total du panier en ajoutant le prix de chaque ligne
        $prixTotal += $panier[$indice]["quantite"] * $ligne["produit"]->getPrix();
    }
    // dd($prixTotal); // (debugging) Affiche le prix total du panier actuel
    // Mise à jour du panier en session avec les modifications apportées
    $session->set("panier", $panier);       
    // Retourne les informations à afficher dans la réponse au format JSON
    return $this->json($nb . "/". $produit->getPrix() . "/" . $prixTotal);
}



}
