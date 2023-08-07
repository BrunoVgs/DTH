<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, TokenStorageInterface $tokenStorage)
    {
        $JWT = $request->cookies->get('jwtToken');

    }

    #[Route('/about', name: 'about')]
    public function about(Request $request): Response
    {
        // Get the JWT token from the request cookies
        $jwtToken = $request->cookies->get('jwtToken');

        // Ensure the JWT token exists
        if (!$jwtToken) {
            // If the token is missing, the user is not authenticated
            throw new AccessDeniedException('Access denied. You must be logged in as a user.');
        }

        // Replace 'your_jwt_secret_key' with the actual secret key used to generate the token
        $jwtSecretKey = 'your_jwt_secret_key';

        try {
            // Decode the JWT token
            $decodedToken = JWT::decode($jwtToken, $jwtSecretKey, ['HS256']);

            // Access the user data from the decoded token
            $user = $decodedToken->username; // Change 'username' to the actual property in your token that holds the username

            // Now you can use the $user data in your template or any other logic
            return $this->render('home/index.html.twig', [
                'user' => $user,
                // Your other template variables here...
            ]);
        } catch (\Exception $e) {
            // If there's an error decoding the token or the token is invalid, handle the exception
            throw new \RuntimeException('Invalid JWT token: ' . $e->getMessage());
        }
    
    }

    #[Route('/mission', name: 'mission')]
    public function mission(): Response
    {
        return $this->render('home/mission.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
