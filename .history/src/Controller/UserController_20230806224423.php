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
    public function index(): Response
    {

        $user = $this->getUser();

        return $this->render('user/profile.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user
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

    #[Route('/admin/user/update/{id}', name: 'admin_user_update')]
    public function userUpdate(
        int $id,
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

if ($request->isMethod('POST')) {
    $firstname = $request->request->get('firstname');
    $lastname = $request->request->get('lastname');
    $email = $request->request->get('email');
    $age = $request->request->get('age');
    $weight = $request->request->get('weight');
    $height = $request->request->get('height');
    $adress = $request->request->get('address');
    $postalcode = $request->request->get('postalcode');
    $city = $request->request->get('city');
    $phonenumber = $request->request->get('phonenumber');
    $roles = $request->request->get('roles');

    // Mettre à jour les informations de l'utilisateur
    $user->setFirstname($firstname);
    $user->setLastname($lastname);
    $user->setEmail($email);
    $user->setAge($age);
    $user->setWeight($weight);
    $user->setHeight($height);
    $user->setAdress($adress);
    $user->setPostalcode($postalcode);
    $user->setCity($city);
    $user->setPhonenumber($phonenumber);
    $user->setRoles([$roles]); // Si $roles est une chaîne de caractères séparée par des virgules, vous pouvez utiliser explode(',', $roles) pour le convertir en tableau.

    // Persistez les changements dans la base de données
    $entityManager->flush();

    // Redirigez l'utilisateur vers la page de visualisation des informations de l'utilisateur
    return $this->render('admin/user.html.twig', [
        'controller_name' => 'AdminController',
        'user' => $user
    ]);
}
    }

    #[Route('/admin/user/delete/{id}', name: 'admin_user_delete')]
    public function userDelete(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $entityManager->remove($user);
        $entityManager->flush();

        // Rediriger vers la page de la liste des utilisateurs ou vers une autre page de votre choix
        return $this->redirectToRoute('admin_user');
    }
}
