<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AppointmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CollectionCenterRepository;
use App\Repository\UserRepository;
use App\Repository\DonationRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;



class AdminController extends AbstractController
{
    #[Route('/admin/', name: 'admin')]
    public function index(
        UserRepository $userRepository,
        DonationRepository $donationRepository,
        messageRepository $messageRepository,
    ): Response {
        $users = $userRepository->findAll();
        $donations = $donationRepository->findAll();
        $messages = $messageRepository->findAll();
        $donations = $donationRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
            'donations' => $donations,
            'messages' => $messages
        ]);
    }

    #[Route('/admin/user', name: 'admin_user')]
    public function user(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('admin/user.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
        ]);
    }

    #[Route('/admin/user/{id}', name: 'admin_user_edit')]
    public function userEdit(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        return $this->render('admin/useredit.html.twig', [
            'controller_name' => 'AdminController',
            'user' => $user

        ]);
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
            return $this->redirectToRoute('admin_user');
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


    #[Route('/admin/donation', name: 'admin_donation')]
    public function donation(
        UserRepository $userRepository,
        DonationRepository $donationRepository,
        CollectionCenterRepository $centerRepository,
        AppointmentRepository $appointmentRepository
    ): Response {
        $users = $userRepository->findAll();
        $donations = $donationRepository->findAll();
        $centers = $centerRepository->findAll();
        $appointments = $appointmentRepository->findPastAppointments();

        return $this->render('admin/donation.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
            'users' => $users,
            'donations' => $donations,
            'centers' => $centers,
            'appointments' => $appointments
        ]);
    }

    #[Route('/admin/center', name: 'admin_center')]
    public function center(CollectionCenterRepository $centerRepository): Response
    {
        $centers = $centerRepository->findAll();
        return $this->render('admin/center.html.twig', [
            'controller_name' => 'AdminController',
            'centers' => $centers,
        ]);
    }

    #[Route('/admin/center/{id}', name: 'admin_center_edit')]
    public function centerEdit(int $id, CollectionCenterRepository $centerRepository): Response
    {
        $center = $centerRepository->find($id);
        return $this->render('admin/centeredit.html.twig', [
            'controller_name' => 'AdminController',
            'center' => $center

        ]);
    }

    #[Route('/admin/center/update/{id}', name: 'admin_center_update')]
    public function centerUpdate(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        CollectionCenterRepository $centerRepository
    ): Response {
        $center = $centerRepository->find($id);

        if (!$center) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $address = $request->request->get('address');
            $postalcode = $request->request->get('postalcode');
            $city = $request->request->get('city');
            $availableseats = $request->request->get('availableseats');

            // Mettre à jour les informations de l'utilisateur
            $center->setName($name);
            $center->setAddress($address);
            $center->setPostalCode($postalcode);
            $center->setCity($city);
            $center->setAvailableSeats($availableseats);

            // Persistez les changements dans la base de données
            $entityManager->flush();

            // Redirigez l'utilisateur vers la page de visualisation des informations de l'utilisateur
            return $this->redirectToRoute('admin_center');
        }
    }

    #[Route('/admin/center/delete/{id}', name: 'admin_center_delete')]
    public function centerDelete(int $id, CollectionCenterRepository $centerRepository, EntityManagerInterface $entityManager): Response
    {
        $center = $centerRepository->find($id);

        if (!$center) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $entityManager->remove($center);
        $entityManager->flush();

        // Rediriger vers la page de la liste des utilisateurs ou vers une autre page de votre choix
        return $this->redirectToRoute('admin_center');
    }

    /**
     * @Route("/admin/messagerie", name="admin_messagerie")
     */
    public function messagerie(MessageRepository $messageRepository): Response
    {
        $messages = $messageRepository->findAll();

        return $this->render('admin/messagerie.html.twig', [
            'messages' => $messages,
        ]);
    }

    #[Route('/admin/messagerie/{id}', name: 'admin_message_read')]
    public function messageRead(
        int $id,
        MessageRepository $messageRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $message = $messageRepository->find($id);
    
        if (!$message) {
            throw $this->createNotFoundException('Message not found');
        }
    
        $message->setIsRead(true);
        $entityManager->flush();
        
        return $this->render('admin/messageread.html.twig', [
            'controller_name' => 'AdminController',
            'message' => $message
        ]);
    }
}
