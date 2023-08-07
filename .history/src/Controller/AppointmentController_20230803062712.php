<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Appointment;

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
        $user = $this->getUser();
        $centerId = $request->request->get('center_id');
        $appointmentDate = $request->request->get('appointment')['appointmentDate'];
        $appointmentTime = $request->request->get('appointment')['appointmentTime'];
        $bloodGroup = $request->request->get('appointment')['bloodGroup'];
        $medication = $request->request->get('appointment')['medication'];
        $consent = $request->request->get('appointment')['consent'];

        // On récupere le centre de collecte associé à l'ID envoyé dans le formulaire
        $center = $entityManager->getRepository(CollectionCenter::class)->find($centerId);

        // On crée une instance de l'entité Appointment et associez les données
        $appointment = new Appointment();
        $appointment->setAppointmentDateTime(new \DateTime($appointmentDate . ' ' . $appointmentTime));
        $appointment->setBloodGroup($bloodGroup);
        $appointment->setMedication($medication);
        $appointment->setConsent($consent);
        $appointment->setCollectionCenter($center);
        $appointment->setUser($user); // Associer l'utilisateur actuel

        // On Persiste l'entité en utilisant l'EntityManager
        $entityManager->persist($appointment);
        $entityManager->flush();

        // On Redirige vers une page de confirmation ou faire d'autres actions si nécessaires
        return $this->redirectToRoute('home');
    }
}
