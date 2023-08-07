<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppointmentController extends AbstractController
{
    #[Route('/appointment', name: 'appointment')]
    public function index(Request $request): Response
    {
        $centerName = $request->request->get('center_name');
        $centerAddress = $request->request->get('center_address');
        $centerCity = $request->request->get('center_city');
        $centerPostalCode = $request->request->get('center_postal_code');
        $centerId = $request->request->get('center_id');
        

        return $this->render('appointment/index.html.twig', [
            'controller_name' => 'AppointmentController',
            'centerName' => $centerName,
            'centerAddress' => $centerAddress,
            'centerCity' => $centerCity,
            'centerPostalCode' => $centerPostalCode,
            'centerId' => $centerId
        ]);
    }

    #[Route('/appointment/process', name: 'appointment_process', methods: ['POST'])]
    public function createAppointment(Request $request, EntityManagerInterface $entityManager): Response
    {
        $centerId = $request->request->get('center_id');
        $centerName = $request->request->get('center_name');
        $centerAddress = $request->request->get('center_address');
        $centerCity = $request->request->get('center_city');
        $centerPostalCode = $request->request->get('center_postal_code');

        // Créez une instance de l'entité Appointment et associez les données
        $appointment = new Appointment();
        // Associez les données du centre de collecte au rendez-vous
        $appointment->setCenterId($centerId);
        $appointment->setCenterName($centerName);
        $appointment->setCenterAddress($centerAddress);
        $appointment->setCenterCity($centerCity);
        $appointment->setCenterPostalCode($centerPostalCode);

        // ... Autres propriétés du rendez-vous ...

        // Persistez l'entité en utilisant l'EntityManager
        $entityManager->persist($appointment);
        $entityManager->flush();

        // Rediriger vers une page de confirmation ou faire d'autres actions si nécessaires

        return $this->redirectToRoute('confirmation');
    }
}
