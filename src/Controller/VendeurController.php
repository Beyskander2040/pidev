<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
Use App\Form\EditProfileType;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

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
    #[Route('/profile', name: 'profile')]
    
    public function profile(): Response
    {

        $user = $this->getUser();
        return $this->render('vendeur/profile.html.twig', [
            'user' => $user,
        
            
        ]);
    }

    #[Route('/profile/modifier/{id}', name: 'modifier_profile')]
    
    public function editprofile(User $user, Request $request, TranslatorInterface $translator)
    {
        
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);
       

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

          

            $this->addFlash('message', ' Profil mis a jour');
            return $this->redirectToRoute('vendeur_profile');
        }
        
        return $this->render('vendeur/editprofile.html.twig', [
            'Form' => $form->createView()
        ]);
            
       
    }
}
