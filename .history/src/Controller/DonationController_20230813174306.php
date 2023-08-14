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
            $appointmentId = $data[0]; // L'id du rendez-vous
            $appointmentDateTime = $data[1] . ' ' . $data[2];
            $userFirstName = $data[3];
            $userLastName = $data[4];
            $collectionCenterName = $data[5];
            $bloodGroup = $data[6];
            $medication = $data[7];

            // Stocker les données de donation dans l'array $appointmentsData
            $appointmentsData[] = array(
                'appointmentId' => $appointmentId,
                'appointmentDateTime' => $appointmentDateTime,
                'userFirstName' => $userFirstName,
                'userLastName' => $userLastName,
                'collectionCenterName' => $collectionCenterName,
                'bloodGroup' => $bloodGroup,
                'medication' => $medication
            );
        }

        dump($appointmentsData);

        // Supprimer les rendez-vous sélectionnés de la base de données
        foreach ($appointmentsData as $data) {
            // Recherche de l'objet Appointment correspondant dans la base de données
            $appointment = $entityManager->getRepository(Appointment::class)
                ->find($data['appointmentId']);

            // Vérifier si l'objet Appointment a été trouvé
            if ($appointment) {
                // Supprimer l'objet Appointment de la base de données
                $entityManager->remove($appointment);
            }
        }

        $entityManager->flush();

        // Créer les dons associés
        foreach ($appointmentsData as $data) {
            $donation = new Donation();
            $donation->setDonorFirstName($data['userFirstName']);
            $donation->setDonorLastName($data['userLastName']);
            $donation->setCollectionCenter($data['collectionCenterName']);
            $donation->setDate(new \DateTime($data['appointmentDateTime']));

            $entityManager->persist($donation);

            // Augmenter le nombre de places disponibles dans le centre de collecte associé
            $collectionCenterRepository = $entityManager->getRepository(CollectionCenter::class);
            $center = $collectionCenterRepository->findOneBy(['name' => $data['collectionCenterName']]);

            if ($center) {
                $center->increaseAvailableSeats(); // Augmente d'une place par défaut
                // ou spécifiez le nombre de places à augmenter (par exemple 3 places)
                // $center->increaseAvailableSeats(3);
            }

            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }
    }
}