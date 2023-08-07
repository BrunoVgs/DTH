<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): JsonResponse {


        $data = $request->request->all();

        $user = new User();
        $user->setFirstname($data['first_name']);
        $user->setLastname($data['last_name']);
        $user->setEmail($data['email']);
        $user->setAge((int)$data['age']); // Cast the 'age' value to int
        $user->setWeight((int)$data['weight']); // Cast the 'weight' value to int
        $user->setHeight((int)$data['height']); // Cast the 'height' value to int
        $user->setPhoneNumber($data['phone_number']);

            // Convert the 'birthday' string to DateTime
        $birthdate = $data['birthdate'] ?? null;
        if ($birthdate) {
        $birthdate = \DateTime::createFromFormat('d/m/Y', $birthdate);
        $user->setBirthdate($birthdate);
        }

        // Hacher le mot de passe
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Persiste l'utilisateur dans la base de données
        $entityManager->persist($user);
        $entityManager->flush(); 

        return new JsonResponse(['message' => 'User enregistré']); 
        echo("salut");

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}

