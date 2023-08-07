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
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Logout\LogoutUrlGenerator;
use App\Entity\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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


    #[Route('/login_check', name: 'login_check')]
    public function loginCheck(): void
    {
        // Cette méthode ne fait rien car le composant Security gère automatiquement l'authentification
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): void
    {
        // Cette méthode ne fait rien car le composant Security gère automatiquement la déconnexion
    }
}
