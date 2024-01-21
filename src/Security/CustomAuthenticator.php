<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\AuthenticatorInterface;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Guard\Token\GuardTokenInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class CustomAuthenticator extends AbstractFormLoginAuthenticator implements AuthenticatorInterface, PasswordAuthenticatedInterface
{
    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route') === 'app_login' && $request->isMethod('POST');
    }

    public function authenticate(Request $request): PassportInterface
    {
       
        $email = $request->request->get('email');
        $password = $request->request->get('password');

     
        $passport = new UserPassportInterface(
            new UserBadge($email),
            new PasswordCredentials($password)
        );

        return $passport;
    }

    public function onAuthenticationSuccess(Request $request, PassportInterface $passport, TokenInterface $token): ?Response
    {
      
        return new RedirectResponse($this->urlGenerator->generate('app_success'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
       
        throw new CustomUserMessageAuthenticationException('Identifiants invalides.');
    }
}
