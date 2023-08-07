<?php 
namespace App\Controller;

use App\Entity\User;
use App\Repository\AppointmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CollectionCenterRepository;
use App\Repository\UserRepository;
use App\Repository\DonationRepository;

class AdminController extends AbstractController
{
    #[Route('/admin/', name: 'admin')]
    public function index(
        UserRepository $userRepository, 
        DonationRepository $donationRepository,
        ): Response
    {
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
        #[Route('/user/edit/{id}', name: 'user_edit')]
    }
    
    public function edit(User $user): Response
    {
        // Vous pouvez maintenant utiliser l'objet $user pour accéder aux données de l'utilisateur que vous souhaitez éditer

        // Remplacez 'user/edit.html.twig' par le nom de votre template d'édition d'utilisateur
        return $this->render('user/edit.html.twig', [
            'user' => $user,
        ]);
    }


    #[Route('/admin/donation', name: 'admin_donation')]
    public function donation(
        UserRepository $userRepository, 
        DonationRepository $donationRepository,
        CollectionCenterRepository $centerRepository,
        AppointmentRepository $appointmentRepository
        ): Response
    {
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
}
