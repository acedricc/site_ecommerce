<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class MailerService{
/**
 * @var MailerInterface
 */

    private $mailer;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * MailerService constructor.
     * 
     * @param MailerInterface       $mailer
     * @param Environment   $twig 
     */

     public function __construct(MailerInterface $mailer, Environment $twig )
     {
        $this->mailer = $mailer;
        $this->twig = $twig;
     }
     /**un sujet, celui qui envoie le mail,celui qui recois le mail,le template du mail
      * @param string $subject
      * @param string $from
      * @param string $to
      * @param string $template
      * @param array $parameters
      * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
      * @throws \Twig\Error\LoaderError
      * @throws \Twig\Error\RuntimeError
      * @throws \Twig\Error\SyntaxError
      */

      public function send(string $subject, string $from, string $to, string $template, array $parameters ): void
      {
          $email = (new Email())
          ->from($from)
          ->to($to)
          ->subject($subject)
        //   ->attachFromPath()
          ->html(
              $this->twig->render($template, $parameters),
              charset: 'text/html'
            
          );

          $this->mailer->send($email);
      }
}
