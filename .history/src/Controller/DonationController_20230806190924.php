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
        // Récupérer les valeurs des cases à cocher depuis le formulaire
        $selectedAppointments = $request->request->get('selected_appointments');

        // Tableau pour stocker les données de donation
        $appointmentsData = array();
        foreach ($selectedAppointments as $selectedAppointment) {
            $data = explode('_', $selectedAppointment);
            $appointmentDateTime = $data[0] . ' ' . $data[1];
            $userFirstName = $data[2];
            $userLastName = $data[3];
            $collectionCenterName = $data[4];
            $bloodGroup = $data[5];
            $medication = $data[6];

            // Stocker les données de donation dans l'array $appointmentsData
            $appointmentsData[] = array(
                'appointmentDateTime' => $appointmentDateTime,
                'userFirstName' => $userFirstName,
                'userLastName' => $userLastName,
                'collectionCenterName' => $collectionCenterName,
                'bloodGroup' => $bloodGroup,
                'medication' => $medication
            );
        }

        // Vous pouvez maintenant utiliser $appointmentsData comme bon vous semble
        // Par exemple, pour afficher les données dans le terminal :
        dump($appointmentsData);

        // Maintenant, vous pouvez effectuer la persistance des données en utilisant les index de $appointmentsData
        foreach ($appointmentsData as $data) {
            $donation = new Donation();
            $donation->setDonorFirstName($data['userFirstName']);
            $donation->setDonorLastName($data['userLastName']);
            $donation->setCollectionCenter($data['collectionCenterName']);
            $donation->setDate(new \DateTime($data['appointmentDateTime']));
            $donation->setBloodGroup($data['bloodGroup']);
            $donation->setMedication($data['medication']);

            // Persister l'entité Donation dans la base de données
            $entityManager->persist($donation);
        }

        // Exécuter les opérations d'écriture dans la base de données
        $entityManager->flush();

        // À partir de ce point, vous pouvez effectuer d'autres traitements avec les données récupérées

        // Retourner une réponse appropriée
        return $this->redirectToRoute('home');
    }
}