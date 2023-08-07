<?php

use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class JwtAuthenticator extends JWTTokenAuthenticator
{
    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        // No need to manually decode the JWT token, as the parent class handles it.
        // The user provider will be responsible for loading the user based on the token's data.
        return $userProvider->loadUserByUsername($credentials['username']);
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        // No additional password check is needed for JWT authentication
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // Handle authentication failure (e.g., redirect to the login page with an error message)
        return new RedirectResponse($this->urlGenerator->generate('login'));
    }

    public function start(Request $request, AuthenticationException $authException = null): ?Response
    {
        // Redirect to the login page if authentication is required (e.g., accessing a protected resource)
        return new RedirectResponse($this->urlGenerator->generate('login'));
    }

    public function supportsRememberMe(): bool
    {
        // Return true if you want to support the "remember me" feature
        return true;
    }

    protected function getLoginUrl(): string
    {
        // Return the login page URL
        return $this->urlGenerator->generate('login');
    }
}
