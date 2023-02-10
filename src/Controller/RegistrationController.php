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
        
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
           
            $user->setRoles(["ROLE_CLIENT"]);
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
                 //Email
                 $email = (new TemplatedEmail())
                 ->from($user->getEmail())
                 ->to('admin.recipices@lepoles.org ')
                 ->subject('Inscription')
                //  ->text('Sending emails is fun again!')
                //  ->html($user->getPseudo());

                // path of the Twig template to render
                ->htmlTemplate('registration/signup.html.twig')
                // pass variables (name => value) to the template
                ->context([
                    // 'expiration_date' => new \DateTime('+7 days'),
                    'users' => $user,
                    
                ]);
                 $mailer->send($email);

                 $this->addFlash('success' ,'Votre compte a bien été crée');
               

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request,
              
            );
        }
     

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    
} 
    }
    
