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


    #[Route('/admin/user/edit/{id}', name: 'admin_user_edit', methods: ['GET'])]
    public function usereditForm(User $user): Response
    {
        // Créez un formulaire pour afficher les informations de l'utilisateur
        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, ['disabled' => true])
            ->add('email', TextType::class, ['disabled' => true])
            ->getForm();

        // Affichez le formulaire d'édition dans le template 'admin/useredit.html.twig'
        return $this->render('admin/useredit.html.twig', [
            'form' => $form->createView(),
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
