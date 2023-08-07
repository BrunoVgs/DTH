<?php 
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
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
        return $this->render('admin/users.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
        ]);
    }

    #[Route('/admin/donation', name: 'admin_user')]
    public function donation(
        UserRepository $userRepository, 
        DonationRepository $donationRepository,
        ): Response
    {
        $users = $userRepository->findAll();
        $donations = $donationRepository->findAll();

        return $this->render('admin/users.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
            'users' => $users,
            'donations' => $donations,
            'centers' => $centers
        ]);
    }
}
