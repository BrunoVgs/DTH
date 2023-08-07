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

    public function getCredentials(Request $request)
    {
        $token = parent::getCredentials($request);

        if (!$token) {
            return null;
        }

        // Your secret key used to sign the JWT token (this should be the same key used to generate the token)
        $secretKey = 'your_secret_key_here';

        try {
            // Decode the JWT token
            $decodedToken = JWT::decode($token, $secretKey, array('HS256'));

            // Convert the decoded token to an array
            $data = (array) $decodedToken;

            // Return the data as credentials for the user
            return $data;
        } catch (Exception $e) {
            // Failed to decode the token (e.g., invalid token, signature mismatch, etc.)
            // Handle the error appropriately (e.g., log, return an error response, etc.)
            throw new AuthenticationException('Invalid JWT Token');
        }
    }
}
