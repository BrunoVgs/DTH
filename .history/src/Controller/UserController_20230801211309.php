<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface

class UserController extends AbstractController
{
    #[Route('/user/profile', name: 'app_user')]
    public function index(): Response
    {

        $user = $this->getUser();

        return $this->render('user/profile.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user
        ]);
    }
}
