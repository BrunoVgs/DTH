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
        
        $user = $this->$security->getUser();
        dump($request->headers->get('cookie'));

        // You can now use $user in the template
        return $this->render('home/index.html.twig', [
            'user' => $user,
            // Your other template variables here...
        ]);

        dump($user);
    }

    #[Route('/about', name: 'about')]
    public function about(Request $request): Response
    {
        $JWT = $request->cookies->get('JWT');

        if (!$JWT) {
            // Si le token JWT n'est pas présent dans le cookie, l'utilisateur n'est pas authentifié
            throw new AccessDeniedException('Accès refusé. Vous devez être connecté en tant qu\'utilisateur.');
        }
    
        // Vous pouvez également vérifier l'intégrité du token JWT ici si vous le souhaitez
    
        return $this->render('home/about.html.twig', [
            'controller_name' => 'HomeController',
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
