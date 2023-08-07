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
        $selectedAppointments = $request->request->get('selected_appointments');

        $appointmentsData = array();
        foreach ($selectedAppointments as $selectedAppointment) {
            $data = explode('_', $selectedAppointment);
            $appointmentDateTime = $data[0] . ' ' . $data[1];
            $userFirstName = $data[2];
            $userLastName = $data[3];
            $collectionCenterName = $data[4];
            $bloodGroup = $data[5];
            $medication = $data[6];

            $appointmentsData[] = array(
                'appointmentDateTime' => $appointmentDateTime,
                'userFirstName' => $userFirstName,
                'userLastName' => $userLastName,
                'collectionCenterName' => $collectionCenterName,
                'bloodGroup' => $bloodGroup,
                'medication' => $medication
            );
        }

        dump($appointmentsData);

        foreach ($appointmentsData as $data) {
            $donation = new Donation();
            $donation->setDonorFirstName($data['userFirstName']);
            $donation->setDonorLastName($data['userLastName']);
            $donation->setCollectionCenter($data['collectionCenterName']);
            $donation->setDate(new \DateTime($data['appointmentDateTime']));

            $entityManager->persist($donation);
        }

        $entityManager->flush();

        return $this->redirectToRoute('home');
    }
}