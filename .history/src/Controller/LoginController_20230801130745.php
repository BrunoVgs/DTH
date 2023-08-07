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

    #[Route('/login/process', name: 'login_post', methods: ['POST'])]
    public function loginPost(
        Request $request,
        JwtAuthenticator $jwtAuthenticator
    ): Response {
        // Get the JWT token from the request cookies
        $jwtToken = $request->cookies->get('JWT');

        // Ensure the JWT token exists
        if (!$jwtToken) {
            throw new AuthenticationException('Access denied. You must be logged in as a user.');
        }

        // Authenticate the user based on the JWT token
        $user = $jwtAuthenticator->authenticateUserByJwtToken($jwtToken);

        // Now you have the authenticated user and can use it in your application

        // Your other logic here...

        return $this->render('home/index.html.twig', [
            'user' => $user,
            // Your other template variables here...
        ]);
    }

    #[Route('/logout', name: 'logout')]
public function logout(LogoutUrlGenerator $logoutUrlGenerator): RedirectResponse
{
    // This method can be empty, as it's handled by Symfony's security system
    return new RedirectResponse($logoutUrlGenerator->getLogoutUrl());
}
}
