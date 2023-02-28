<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginAuthentificator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    // Route utilisée pour la page de connexion
    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    // Cette méthode est appelée à chaque fois qu'un utilisateur tente de se connecter
    public function authenticate(Request $request): Passport
    {
        // On récupère le nom d'utilisateur saisi dans le formulaire de connexion
        $pseudo = $request->request->get('pseudo', '');

        // On stocke le nom d'utilisateur dans la session pour pouvoir l'afficher à nouveau s'il y a une erreur de connexion
        $request->getSession()->set(Security::LAST_USERNAME, $pseudo);

        // On crée un passeport contenant les informations d'authentification de l'utilisateur (nom d'utilisateur et mot de passe)
        // ainsi qu'un jeton CSRF pour éviter les attaques CSRF (Cross-Site Request Forgery)
        return new Passport(
            new UserBadge($pseudo),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    // Cette méthode est appelée lorsque l'authentification est réussie
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Si l'utilisateur a été redirigé vers la page de connexion avant d'être redirigé vers la page de destination souhaitée,
        // on le redirige vers la page de destination souhaitée (stockée dans la session)
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // Sinon, on le redirige vers la page de profil
        return new RedirectResponse($this->urlGenerator->generate('app_profil'));
        // throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    // Cette méthode est appelée lorsque l'authentification a échoué et que l'utilisateur doit être redirigé vers la page de connexion
    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
