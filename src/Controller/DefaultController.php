<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\MessageService;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route ("/", name="default")]
     * @return Response
     */

    public function index(): Response
    {
        return $this->render(view:'default/index.html.twig',[
            'controller_name' => 'DefaultController',
        ]);
    }

    /** 
     *@Route("/contact", name="contact")
     *@param Request $request
     *@param MessageService $messageService
     *@param MailerService $mailerService
     *@return Response
    */
    public function contact(
        Request $request,
        MessageService $messageService,
        MaillerService $maillerService
    ): Response
    {
        $formContact = $this->createForm(type: ContactType::class, data:null);
        $formContact->handleRequest($request);

        if ($formContact->isSubmitted() && $formContact->isValid()) {
            $data = $formContact->getData();
            $maillerService->send(
            subject: "Nouveau Message",
            from: "test@gmail.com",
            to: "cedric.akakpo@lepoles.org",
            template: "email/contact.html.twig",
            [
                "name" => $data['name'],
                "description" => $data['description']
            ]
            );

            $messageService->addSuccess('Votre message a bien ete valider .');
        }

        return $this->render(view: 'default/contact.html.twig', [
            'formContact' => $formContact->createView()
        ]);
    }
}
