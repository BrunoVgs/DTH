<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use App\Entity\User;

class LoginController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        return $this->render('security/register.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    #[Route('/register/process', name: 'register_post', methods: ['POST'])]
    public function registerPost(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {


        $data = $request->request->all();

        $user = new User();
        $user->setFirstname($data['first_name']);
        $user->setLastname($data['last_name']);
        $user->setEmail($data['email']);
        $user->setAge((int)$data['age']);
        $user->setWeight((int)$data['weight']);
        $user->setHeight((int)$data['height']);
        $user->setPhoneNumber($data['phone_number']);
        $user->setRoles(['ROLE_USER']);

        // Conversion de la date de naissance de string en datetime
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

        return $this->redirectToRoute('home');
    }

    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('security/login.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $jwtManager,
        EntityManagerInterface $entityManager
    ): Response {
        $data = json_decode($request->getContent(), true);

        // Check if the required fields are provided
        if (!isset($data['email']) || !isset($data['password'])) {
            throw new AuthenticationException('Email and password are required.');
        }

        // Find the user by email
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $data['email']]);

        // Check if the user exists
        if (!$user) {
            throw new AuthenticationException('User not found.');
        }

        // Check if the email is verified
        if (!$user->isVerified()) {
            throw new AuthenticationException('Email not verified.');
        }

        // Verify the password
        if (!$passwordEncoder->isPasswordValid($user, $data['password'])) {
            throw new AuthenticationException('Invalid credentials.');
        }

        // If login is successful, generate the JWT token
        $token = $jwtManager->create($user);

        return $this->json(['token' => $token]);
    }
}

