<?php


namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class JwtAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    use TargetPathTrait;

    private $jwtManager;

    public function __construct(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    // Implement the AuthenticationEntryPointInterface methods
    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        // Handle the case when an anonymous user tries to access a protected page
        // You can redirect them to the login page or return a 401 Unauthorized response
        // For example, redirect to the login page with an error message
        return new RedirectResponse('/login?error=Authentication%20required');
    }

    public function supports(Request $request): ?bool
    {
        // Check if the request contains the JWT token (e.g., in the Authorization header or as a cookie)
        return $request->headers->has('Authorization') || $request->cookies->has('jwtToken');
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
