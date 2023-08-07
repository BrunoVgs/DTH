<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\CookieTokenExtractor;

use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    public function index(Request $request, TokenStorageInterface $tokenStorage)
    {
        // Get the JWT token from the request cookies
        $cookieExtractor = new CookieTokenExtractor('JWT'); // Replace 'JWT' with the actual name of your JWT cookie
        $jwtToken = $cookieExtractor->extract($request);
    
        // Ensure the JWT token exists
        if (!$jwtToken) {
            // If the token is missing, the user is not authenticated
            throw new AccessDeniedException('Access denied. You must be logged in as a user.');
        }
    
        // Set the token in the token storage
        $tokenStorage->setToken($jwtToken);
    
        // Get the authenticated user from the token storage
        $user = $tokenStorage->getToken()->getUser();
    
        // You can now use $user in the template
        return $this->render('home/index.html.twig', [
            'user' => $user,
            // Your other template variables here...
        ]);
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
