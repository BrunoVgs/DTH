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
}
