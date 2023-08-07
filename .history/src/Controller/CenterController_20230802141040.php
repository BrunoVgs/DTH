<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CollectionCenter;

class CenterController extends AbstractController
{
    #[Route('/center', name: 'center')]
    public function index(): Response
    {

        $repository = $this->entityManager->getRepository(CollectionCenter::class);
        $centers = $repository->findAll();

        return $this->render('center/index.html.twig', [
            'centers' => $centers,
        ]);
    }
}
