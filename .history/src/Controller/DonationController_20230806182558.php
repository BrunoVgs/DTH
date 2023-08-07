<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Donation;
use App\Entity\Appointment;
use App\Entity\CollectionCenter;

class DonationController extends AbstractController
{
    #[Route('/create_donation', name: 'create_donation', methods: ['POST'])]
    public function createDonation(Request $request, EntityManagerInterface $entityManager): Response
    {
    $appointmentDates = $request->request->get('appointment_dates');
    $appointmentTimes = $request->request->get('appointment_times');
    $userFirstnames = $request->request->get('user_firstname');
    $userLastnames = $request->request->get('user_lastname');
    $centerNames = $request->request->get('center_names');
}
}
