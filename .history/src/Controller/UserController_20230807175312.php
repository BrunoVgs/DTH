<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Repository\UserRepository;

class UserController extends AbstractController
{
    #[Route('/user/profile', name: 'user_profile')]
    public function index(DonationRepository $donationRepository): Response
    {

        // Récupérer l'utilisateur connecté
        $user = $this->getUser();
        
        // Récupérer les donations de l'utilisateur en utilisant son nom et prénom
        $donations = $donationRepository->findByDonorName($user->getFirstName(), $user->getLastName());

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'donations' => $donations,
        ]);
    
    }

    #[Route('/user/profile/update', name: 'user_profile_update', methods: ['POST'])]
    public function updateProfile(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Get the authenticated user
        $user = $this->getUser();
        dump($user);
        // Process the form submission
        $user->setFirstname($request->request->get('firstname'));
        $user->setLastname($request->request->get('lastname'));
        $user->setAdress($request->request->get('address'));
        $user->setPostalCode($request->request->get('postal_code'));
        $user->setCity($request->request->get('city'));
        $user->setWeight($request->request->get('weight'));
        $user->setHeight($request->request->get('height'));
        $user->setPhoneNumber($request->request->get('phone_number'));
        $user->setAge($request->request->get('age'));

        // Update the user in the database
        $entityManager->flush(); // No need to persist again as the user is already managed by Doctrine

        // Redirect to the profile page after the update
        return $this->redirectToRoute('home');
    }

}