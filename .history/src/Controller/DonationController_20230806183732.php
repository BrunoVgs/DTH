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
        foreach ($selectedAppointmentsData as $appointmentId) {
            $donationData = [
                'appointment_id' => (int) $appointmentId,
                'date' => new \DateTime($request->request->get('appointment_dates')[$appointmentId]),
                'time' => $request->request->get('appointment_times')[$appointmentId],
                'user_firstname' => $request->request->get('user_firstnames')[$appointmentId],
                'user_lastname' => $request->request->get('user_lastnames')[$appointmentId],
                'center_name' => $request->request->get('center_names')[$appointmentId],
                'blood_group' => $request->request->get('blood_groups')[$appointmentId],
                'medication' => $request->request->get('medications')[$appointmentId] === 'Oui',
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