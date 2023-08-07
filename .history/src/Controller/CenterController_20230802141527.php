<?php

namespace App\Controller;

use App\Entity\CollectionCenter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CenterController extends AbstractController
{
    #[Route('/register/process', name: 'register_post', methods: ['POST'])]
    public function index(
        Request $request, 
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        
        $repository = $this->entityManager->getRepository(CollectionCenter::class);
        $center = $repository->findAll();

        return $this->render('center/index.html.twig', [
            'center' => $center,
        ]);
    }
}
