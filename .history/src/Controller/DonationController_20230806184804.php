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
            $data = explode('_', $appointmentData);
            $donationData = [
                'date' => new \DateTime($data[0]),
                'time' => $data[1],
                'user_firstname' => $data[2],
                'user_lastname' => $data[3],
                'center_name' => $data[4],
                'blood_group' => $data[5],
                'medication' => $data[6],
            ];

            $donationsData[] = $donationData;
        }

        // Dump the selected data to check what you received
        dump($donationsData);

        // Process the selected data and create donations accordingly
        // ...

        // Return a Response with the data
        $responseData = ['message' => 'Donation(s) created successfully', 'data' => $donationsData];
        return $this->redirectToRoute('home', ['data' => json_encode($donationsData)]);
    }
}