<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
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

        return $this->render('home/index.html.twig', [
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
    public function contact(EntityManagerInterface $entityManager): Response

    {
        $user = $this->$entityManager->getUser();

        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
