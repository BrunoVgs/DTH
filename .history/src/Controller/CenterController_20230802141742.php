<?php

namespace App\Controller;

use App\Entity\CollectionCenter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Attribute\Required;

class CenterController extends AbstractController
{
    #[Route('/center', name: 'center')]
    public function index(#[Required] EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(CollectionCenter::class);
        $centers = $repository->findAll();

        return $this->render('center/index.html.twig', [
            'centers' => $centers,
        ]);
    }
}
