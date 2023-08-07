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
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



class AdminController extends AbstractController
{
    #[Route('/admin/', name: 'admin')]
    public function index(
        UserRepository $userRepository,
        DonationRepository $donationRepository,
    ): Response {
        $users = $userRepository->findAll();
        $donations = $donationRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
            'donations' => $donations,
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

    #[Route('/admin/center/delete/{id}', name: 'admin_center_delete')]
    public function centerDelete(int $id, CollectionCenterRepository $centerRepository,EntityManagerInterface $entityManager): Response
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
}
