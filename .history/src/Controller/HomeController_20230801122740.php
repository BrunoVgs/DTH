<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    public function index(Request $request, JWTTokenManagerInterface $jwtManager)
    {
        // Get the JWT token from the request cookies
        $jwtToken = (string) $request->cookies->get('JWT');
    
        // Ensure the JWT token exists
        if (!$jwtToken) {
            // If the token is missing, the user is not authenticated
            throw new AccessDeniedException('Access denied. You must be logged in as a user.');
        }
    
        try {
            // Decode the JWT token using the Lexik JWT manager
            $decodedToken = $jwtManager->decode($jwtToken);
    
            // Access the user data from the decoded token
            $user = $decodedToken['username']; // Replace 'username' with the actual claim name that holds the username in your token
    
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
