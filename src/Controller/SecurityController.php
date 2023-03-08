<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Vérifie si l'utilisateur est déjà connecté. Si c'est le cas, il est redirigé vers la page "target_path".
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // Récupère les éventuelles erreurs d'authentification stockées en session.
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // Récupère le dernier nom d'utilisateur (saisi dans le champ "Nom d'utilisateur" du formulaire de login)
        // stocké en session.
        $lastUsername = $authenticationUtils->getLastUsername();

        // Renvoie une vue Twig qui affiche le formulaire de login, avec les éventuelles erreurs d'authentification
        // et le dernier nom d'utilisateur saisi.
        // Le fichier Twig utilisé est "security/login.html.twig".
        // Les variables "last_username" et "error" sont transmises à la vue.
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Cette méthode permet de gérer la déconnexion de l'utilisateur.
        // Elle ne fait rien dans ce cas précis car la déconnexion est gérée automatiquement par le système de sécurité
        // de Symfony, via la configuration de la section "logout" dans le fichier "security.yaml".
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
