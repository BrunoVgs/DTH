<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class JwtAuthenticator extends AbstractGuardAuthenticator
{
    use TargetPathTrait;

    private $jwtManager;
    private $urlGenerator;

    public function __construct(JWTTokenManagerInterface $jwtManager, UrlGeneratorInterface $urlGenerator)
    {
        
        $this->jwtManager = $jwtManager;
        $this->urlGenerator = $urlGenerator;
    }

    public function supports(Request $request): bool
    {
        // Check if the request contains the JWT token (e.g., in the Authorization header or as a cookie)
        return $request->headers->has('Authorization') || $request->cookies->has('jwtToken');
    }

    public function getCredentials(Request $request)
    {
        // Return the credentials from the request (e.g., the JWT token)
        return [
            'token' => $request->headers->get('Authorization') ?? $request->cookies->get('jwtToken'),
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        // Decode the JWT token and retrieve the user information
        $user = null;
        $token = $credentials['token'];

        // Replace 'your_jwt_secret_key' with the actual secret key used to generate the token
        $randomBytes = openssl_random_pseudo_bytes(32); // Generate 32 bytes of random data
        $jwtSecretKey = base64_encode($randomBytes);

        try {
            $decodedToken = $this->jwtManager->decode($token);
            $user = $userProvider->loadUserByUsername($decodedToken['username']);
            
            // Dump the user object to see its details
            dump($user);
        } catch (\Exception $e) {
            throw new AuthenticationException('Invalid JWT token: ' . $e->getMessage());
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        // No additional password check is needed for JWT authentication
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Redirect the user to the home page after successful authentication
        return new RedirectResponse($this->urlGenerator->generate('home'));
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
