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
     // Ton code pour récupérer les données sélectionnées
     $selectedAppointmentsData = $request->request->get('selected_appointments');

     if (empty($selectedAppointmentsData)) {
         // Aucun rendez-vous sélectionné, retourner une erreur ou un message approprié
         return new Response('No appointments selected.', Response::HTTP_BAD_REQUEST);
     }

     // Créer un tableau pour regrouper les données par utilisateur
     $donationsDataByUser = [];

     foreach ($selectedAppointmentsData as $appointmentData) {
         $data = explode('_', $appointmentData);
         $userFirstname = $data[2];
         $userLastname = $data[3];

         // Vérifier si l'utilisateur existe déjà dans le tableau
         if (isset($donationsDataByUser[$userFirstname . ' ' . $userLastname])) {
             // L'utilisateur existe, ajouter les données à son tableau existant
             $donationsDataByUser[$userFirstname . ' ' . $userLastname][] = [
                 'date' => new \DateTime($data[0]),
                 'time' => $data[1],
                 'center_name' => $data[4],
                 'blood_group' => $data[5],
                 'medication' => $data[6],
             ];
         } else {
             // L'utilisateur n'existe pas encore, créer un tableau avec les données
             $donationsDataByUser[$userFirstname . ' ' . $userLastname] = [
                 [
                     'date' => new \DateTime($data[0]),
                     'time' => $data[1],
                     'center_name' => $data[4],
                     'blood_group' => $data[5],
                     'medication' => $data[6],
                 ]
             ];
         }
     }

     // Dump the donationsDataByUser to check the result
     dump($donationsDataByUser);

     // À partir de maintenant, $donationsDataByUser contient un tableau associatif
     // avec les données regroupées par utilisateur
     // ...

     // Rediriger l'utilisateur vers la page d'accueil avec les données en paramètres
     return $this->redirectToRoute('home', ['data' => json_encode($donationsDataByUser)]);
 }
}