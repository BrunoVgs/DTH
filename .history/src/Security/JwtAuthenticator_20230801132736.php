<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class JwtAuthenticator extends AbstractAuthenticator
{
    public function supports(Request $request): ?bool
    {
        // Implement the logic to check if this authenticator should be used for the given request
        // For example, you can check if the request contains the JWT token cookie
        return $request->cookies->has('JWT');
    }

    public function authenticate(Request $request): Passport
    {
        // Get the JWT token from the request cookie
        $jwtToken = $request->cookies->get('JWT');

        // Validate and decode the JWT token to get the user data
        // Implement your JWT validation logic here

        // Once you have the user data, you can create a UserBadge like this:
        $email = 'user@example.com'; // Replace with the actual email from the JWT token
        return new Passport(
            new UserBadge($email),
            new PasswordCredentials('') // You don't need password credentials for JWT authentication
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // If authentication is successful, Symfony will call this method
        // Redirect the user to the homepage or any other desired page
        return new RedirectResponse($this->urlGenerator->generate('home'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // If authentication fails, Symfony will call this method
        // Redirect the user to the login page or any other desired page
        return new RedirectResponse($this->urlGenerator->generate('login'));
    }
}
