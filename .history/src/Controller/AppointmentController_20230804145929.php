<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Appointment;
use App\Entity\CollectionCenter;
use Symfony\Component\Security\Core\Security;
use App\Repository\AppointmentRepository;


class AppointmentController extends AbstractController
{
    #[Route('/appointment', name: 'appointment')]
    public function index(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            // Le formulaire a été soumis, afficher la page de prise de rendez-vous avec les détails du centre sélectionné
            $centerId = $request->request->get('center_id');
            $centerName = $request->request->get('center_name');
            $centerAddress = $request->request->get('center_address');
            $centerCity = $request->request->get('center_city');
            $centerPostalCode = $request->request->get('center_postal_code');
    
            return $this->render('appointment/index.html.twig', [
                'centerId' => $centerId,
                'centerName' => $centerName,
                'centerAddress' => $centerAddress,
                'centerCity' => $centerCity,
                'centerPostalCode' => $centerPostalCode,
            ]);
        }
    
        // Si le formulaire n'est pas soumis, redirigez l'utilisateur vers la page des rendez-vous
        return $this->redirectToRoute('home');
    }

    #[Route('/appointment/process', name: 'appointment_process', methods: ['POST'])]
    public function createAppointment(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {   
        $user = $security->getUser();
        $centerId = $request->request->get('appointment')['center_id'];
        $appointmentDateTime = $request->request->get('appointment')['appointmentDateTime'];
        $bloodGroup = $request->request->get('appointment')['bloodGroup'];
        $medication = $request->request->get('appointment')['medication'];
        $consent = $request->request->get('appointment')['consent'] === 'on';

        // On récupere le centre de collecte associé à l'ID envoyé dans le formulaire
        $center = $entityManager->getRepository(CollectionCenter::class)->find($centerId);

        // On crée une instance de l'entité Appointment et associez les données
        $appointment = new Appointment();
        $appointment->setAppointmentDateTime(new \DateTime($appointmentDateTime));
        $appointment->setBloodGroup($bloodGroup);
        $appointment->setMedication($medication);
        $appointment->setConsent($consent);
        $appointment->setCollectionCenter($center);
        $appointment->setUser($user); // Associer l'utilisateur actuel

        
        // On Persiste l'entité en utilisant l'EntityManager
        $entityManager->persist($appointment);
        
        // Réduire le nombre de places disponibles dans le centre de collecte
        $center->decreaseAvailableSeats();

        $entityManager->flush();

        // On Redirige vers une page de confirmation ou faire d'autres actions si nécessaires
        return $this->redirectToRoute('home');
    }

    #[Route('/appointments', name: 'appointments')]
    public function viewAppointment(Request $request,AppointmentRepository $appointmentRepository ): Response
    {
        // Get the currently authenticated user
        $user = $this->getUser();

        // Get the appointments for the current user
        $appointments = $appointmentRepository->findBy(['user' => $user]);
        

        return $this->render('appointment/appointments.html.twig', [
            'appointments' => $appointments,
        ]);
    }
}
