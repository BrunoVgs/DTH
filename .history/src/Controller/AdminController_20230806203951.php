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
        
    }

    #[Route('/admin/useredit/{id}', name: 'admin_user_edit')]
    // Ajouter l'annotation ParamConverter pour récupérer l'utilisateur à partir de l'identifiant
    #[ParamConverter('user', class: 'App\Entity\User')]
    public function edit(User $user): Response
    {
        // Vous pouvez maintenant utiliser l'objet $user pour accéder aux données de l'utilisateur que vous souhaitez éditer

        // Remplacez 'admin/edit_user.html.twig' par le nom de votre template d'édition d'utilisateur pour l'administrateur
        return $this->render('admin/edit_user.html.twig', [
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
