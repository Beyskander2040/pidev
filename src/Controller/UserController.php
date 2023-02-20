<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user_')]

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    
    public function index(): Response
    {

        return $this->render('base.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
