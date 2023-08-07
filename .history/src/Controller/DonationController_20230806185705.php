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
        // Récupérer les valeurs des cases à cocher depuis le formulaire
        $selectedAppointments = $request->request->get('selected_appointments');

        // Vous pouvez maintenant traiter ces données et les mettre dans un tableau PHP
        $appointmentsData = array();
        foreach ($selectedAppointments as $selectedAppointment) {
            $data = explode('_', $selectedAppointment);
            $appointmentDateTime = $data[0] . ' ' . $data[1];
            $userFirstName = $data[2];
            $userLastName = $data[3];
            $collectionCenterName = $data[4];
            $bloodGroup = $data[5];
            $medication = $data[6] === 'Oui';

            // Maintenant, vous pouvez faire ce que vous voulez avec ces valeurs, par exemple, les stocker dans un tableau
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

        // À partir de ce point, vous pouvez effectuer d'autres traitements avec les données récupérées

        // Retourner une réponse appropriée
        return new Response('Donation created successfully!');
    }
}