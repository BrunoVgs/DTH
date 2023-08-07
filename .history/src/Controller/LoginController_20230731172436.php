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

    // Retrieve the form data
    $data = $request->request->all();

    // Validate the form data
    $user = new User();
    $user->setFirstname($data['first_name'] ?? '');
    $user->setLastname($data['last_name'] ?? '');
    $user->setAge((int)($data['age'] ?? 0)); // Cast the 'age' value to int
    $user->setWeight((int)($data['weight'] ?? 0)); // Cast the 'weight' value to int
    $user->setHeight((int)($data['height'] ?? 0)); // Cast the 'height' value to int
    $user->setPhoneNumber($data['phone_number'] ?? '');
    
    // Convert the 'birthday' string to DateTime
    $birthdate = $data['birthday'] ?? null;
    if ($birthdate) {
        $birthdate = \DateTime::createFromFormat('d/m/Y', $birthdate);
        $user->setBirthdate($birthdate);
    }

    // Validate the User entity using Symfony's Validator
    $errors = $validator->validate($user);

    if (count($errors) > 0) {
        // If there are validation errors, return them as a JSON response
        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages[] = $error->getMessage();
        }
        return new JsonResponse(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
    }

    // Hash the password
    $hashedPassword = $passwordEncoder->encodePassword($user, $data['password'] ?? '');
    $user->setPassword($hashedPassword);

    // Persist the user in the database
    $entityManager->persist($user);
    $entityManager->flush();

    return new JsonResponse(['message' => 'User enregistré']);

    return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}

