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
    #[Route('/', name: 'home')]
    public function index()
    {
        // Get the authenticated user
        $user = $this->getSession();

        // Dump the user object for debugging
        dump($user);

        return $this->render('home/index.html.twig', [
            // Pass any other data you need to the template
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about()
    {

        return $this->render('home/about.html.twig', [
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
