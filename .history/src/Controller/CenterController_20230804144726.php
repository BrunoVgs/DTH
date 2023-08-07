<?php

namespace App\Controller;

use App\Entity\CollectionCenter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CenterController extends AbstractController
{
    #[Route('/center', name: 'center')]
    #[IsGranted("ROLE_USER")]
    public function index(EntityManagerInterface $entityManager): Response
    {
        
        $repository = $entityManager->getRepository(CollectionCenter::class);
        $centers = $repository->findAll();

        return $this->render('center/index.html.twig', [
            'centers' => $centers,
        ]);
    }
}
