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
        $data = $request->request->all();

        // Dump the data to check what you received
        dump($data);

        // Process the data and create donations accordingly
        // ...

        // Return a Response with the data
        $responseData = ['message' => 'Donation(s) created successfully', 'data' => $data];
        return new Response(json_encode($responseData), Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}