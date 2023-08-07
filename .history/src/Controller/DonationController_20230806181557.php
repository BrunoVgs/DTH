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
        $data = $request->request->all();
        dump($data);
        return $data;
    
        /*
        
        $appointmentIds = json_decode($request->request->get('appointment_ids'), true);

        if (empty($appointmentIds)) {
            return new Response('No appointments selected.', Response::HTTP_BAD_REQUEST);
        }

        // Fetch the appointments by IDs from the database
        $appointments = $entityManager->getRepository(Appointment::class)->findBy(['id' => $appointmentIds]);

        // Create the donation for each appointment
        foreach ($appointments as $appointment) {
            $donation = new Donation();
            $donation->setDonor($appointment->getUser());
            $donation->setDate(new \DateTime());
            // You can set the amount and collection center based on your business logic
            // For example, you can set the amount to a fixed value or use some calculation
            $donation->setAmount('10.00');
            $donation->setCollectionCenter($appointment->getCollectionCenter());
            $entityManager->persist($donation);
        }

        $entityManager->flush();

        return new Response('Donation(s) created successfully.', Response::HTTP_OK);
        */
    }
}
