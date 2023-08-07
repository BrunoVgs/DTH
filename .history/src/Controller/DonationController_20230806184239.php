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
    public function createDonation(Request $request): Response
    {
        $selectedAppointmentsData = $request->request->get('selected_appointments');

        if (empty($selectedAppointmentsData)) {
            // Aucun rendez-vous sélectionné, retourner une erreur ou un message approprié
            return new Response('No appointments selected.', Response::HTTP_BAD_REQUEST);
        }

        $donationsData = [];
        foreach ($selectedAppointmentsData as $appointmentData) {
            $donationData = [
                'date' => new \DateTime($appointmentData['date']),
                'time' => $appointmentData['time'],
                'user_firstname' => $appointmentData['user_firstname'],
                'user_lastname' => $appointmentData['user_lastname'],
                'center_name' => $appointmentData['center_name'],
                'blood_group' => $appointmentData['blood_group'],
                'medication' => $appointmentData['medication'] === 'Oui',
            ];

            $donationsData[] = $donationData;
        }

        // Dump the selected data to check what you received
        dump($donationsData);

        // Process the selected data and create donations accordingly
        // ...

        // Return a Response with the data
        $responseData = ['message' => 'Donation(s) created successfully', 'data' => $donationsData];
        return new Response(json_encode($responseData), Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}