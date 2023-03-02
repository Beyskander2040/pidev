<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
#[Route('/vendeur', name: 'vendeur_')]

class VendeurController extends AbstractController
{
    #[Route('/vendeur', name: 'vendeur')]
    
    public function index(): Response
    {

        return $this->render('vendeur/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
