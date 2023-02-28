<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthentificator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator,LoginAuthentificator $authenticator, EntityManagerInterface $entityManager,MailerInterface $mailer  ): Response
    {
        // Création d'une nouvelle instance de la classe User
        $user = new User();
        // Création d'un formulaire d'inscription à partir de la classe RegistrationFormType
        // et de l'objet $user créé précédemment
        $form = $this->createForm(RegistrationFormType::class, $user);
        // Traitement du formulaire à partir de la requête HTTP
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Cryptage du mot de passe saisi dans le formulaire
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            // Attribution du rôle "ROLE_CLIENT" à l'utilisateur
            $user->setRoles(["ROLE_CLIENT"]);
            // Enregistrement de l'utilisateur en base de données
            $entityManager->persist($user);
            $entityManager->flush();
            // Envoi d'un email de confirmation d'inscription à l'administrateur
            $email = (new TemplatedEmail())
                 ->from($user->getEmail())
                 ->to('admin.recipices@lepoles.org ')
                 ->subject('Inscription')
                ->htmlTemplate('registration/signup.html.twig')
                ->context([
                    'users' => $user,
                ]);
            $mailer->send($email);
            // Ajout d'un message flash pour confirmer la création du compte
            $this->addFlash('success' ,'Votre compte a bien été créé');
            // Authentification de l'utilisateur
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request, 
            );
        }
        // Affichage du formulaire d'inscription
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    } 
}
