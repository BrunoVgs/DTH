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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


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

    #[Route('/admin/user/edit/{id}', name: 'admin_user_edit')]
    public function editUser(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Save the updated user data to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirect to the user list or show a success message
            return $this->redirectToRoute('admin_user');
        }

        return $this->render('admin/edit_user.html.twig', [
            'controller_name' => 'AdminController',
            'form' => $form->createView(),
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
