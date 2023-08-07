<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Message;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController

{
    #[Route('/', name: 'home')]
    public function index()
    {

        return $this->render('home/index.html.twig', []);
    }

    #[Route('/about', name: 'about')]
    public function about()
    {

        return $this->render('home/about.html.twig', []);
    }


    #[Route('/mission', name: 'mission')]
    public function mission(): Response
    {
        return $this->render('home/mission.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    
    #[Route('/contact', name: 'contact')]
    #[IsGranted("ROLE_USER", "ROLE_ADMIN")]
    public function contact(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
    
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
            'user' => $user
        ]);
    }
    

    #[Route('/contact/process', name: 'contact_process')]
    public function contactProcess(EntityManagerInterface $entityManager, Request $request): Response
    {

        // Récupérer l'utilisateur connecté (à condition qu'il soit authentifié)
        $user = $this->getUser();

        if (!$user) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            return $this->redirectToRoute('app_login');
        }

        $messageText = $request->request->get('message');
        $subject = $request->request->get('subject');

        // Créer une instance de l'entité Message et définir ses propriétés
        $message = new Message();
        $message->setContent($messageText);
        $message->setSubject($subject);
        $message->setUser($user); // Associer le message à l'utilisateur connecté

        $message->setCreatedAt(new \DateTime());
        $entityManager->persist($message);

        // Enregistrer le message dans la base de données
        $entityManager->flush();

        // Ajouter un message flash de confirmation
        $this->addFlash('success', 'Votre message a été envoyé, merci !');

        // Rediriger l'utilisateur vers une autre page (par exemple la page de confirmation)
        return $this->redirectToRoute('home'); // Remplacez 'home' par le nom de la route de la page souhaitée
    }
}
