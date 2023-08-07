<?php

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
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;

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
        // Check if the request contains the JWT token (e.g., in the Authorization header)
        $extractor = new AuthorizationHeaderTokenExtractor('Bearer', 'Authorization');
        return $extractor->extract($request) !== false;
    }

    public function getCredentials(Request $request)
    {
        // Return the credentials from the request (e.g., the JWT token)
        $extractor = new AuthorizationHeaderTokenExtractor('Bearer', 'Authorization');
        return [
            'token' => $extractor->extract($request),
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        // Decode the JWT token and retrieve the user information
        $user = null;
        $token = $credentials['token'];

        try {
            $decodedToken = $this->jwtManager->decode($token);
            $username = $decodedToken['username'];

            // Retrieve the user based on the username from the token
            $user = $userProvider->loadUserByUsername($username);

            // If the user does not exist, throw an exception or return null if you prefer
            if (!$user) {
                throw new UsernameNotFoundException('User not found for the given JWT token.');
            }

            // Return the UserInterface object
            return $user;
        } catch (\Exception $e) {
            // Throw a custom authentication exception if the token is invalid or expired
            throw new CustomUserMessageAuthenticationException('Invalid JWT token: ' . $e->getMessage());
        }
    }

    // ...
}
