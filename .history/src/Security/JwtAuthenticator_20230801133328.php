<?php
namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class JwtAuthenticator extends AbstractFormLoginAuthenticator implements PasswordAuthenticatedInterface
{
    private $jwtManager;

    public function __construct(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    public function supports(Request $request): ?bool
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
        $jwtSecretKey = 'your_jwt_secret_key';

        try {
            $decodedToken = $this->jwtManager->decode($token);
            $user = $userProvider->loadUserByUsername($decodedToken['username']);
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

    public function createAuthenticatedToken(UserInterface $user, string $firewallName): PostAuthenticationGuardToken
    {
        // Create a new authenticated token for the user
        return new PostAuthenticationGuardToken($user, $firewallName, $user->getRoles());
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Redirect the user to the home page after successful authentication
        return new RedirectResponse('/home');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // Handle authentication failure (e.g., redirect to the login page with an error message)
        return new RedirectResponse('/login?error=Authentication%20failed');
    }

    protected function getLoginUrl(Request $request): string
    {
        // Return the login page URL
        return '/login';
    }
}
