<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class LoginController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function index(): Response
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    #[Route('/register/process', name: 'register_post', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager
    ): JsonResponse {


      /*  $data = $request->request->all();

        // Créer un nouvel utilisateur
        $user = new User();
        $user->setFirstname($data['first_name']);
        $user->setLastname($data['last_name']);
        $user->setAge($data['age']);
        $user->setWeight($data['weight']);
        $user->setHeight($data['height']);
        $user->setPhoneNumber($data['phone_number']);
        $user->setBirthdate(new \DateTime($data['birthdate'])); // Supposons que la date est envoyée au format 'Y-m-d'

        // Hacher le mot de passe
        $hashedPassword = $passwordEncoder->encodePassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Persiste l'utilisateur dans la base de données
        $entityManager->persist($user);
        $entityManager->flush(); */

        return new JsonResponse(['message' => 'User enregistré']);
    }
}

