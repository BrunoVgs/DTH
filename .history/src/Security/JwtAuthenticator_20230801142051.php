<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use \Firebase\JWT\JWT;

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

}
