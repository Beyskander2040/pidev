<?php

namespace App\Controller;
use App\Entity\User;
use App\Repository\UserRepository;
Use App\Form\EditProfileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\Translation\TranslatorInterface;


#[Route('/user', name: 'user_')]

class UserController extends AbstractController


{
    #[Route('/user', name: 'user')]
    
    public function index(): Response
    {

        return $this->render('base.html.twig', [
            
        ]);
    }

    #[Route('/user/profile', name: 'profile')]
    
    public function profile(): Response
    {

        $user = $this->getUser();
        return $this->render('user/profile.html.twig', [
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
            return $this->redirectToRoute('user_profile');
        }
        
        return $this->render('user/editprofile.html.twig', [
            'Form' => $form->createView()
        ]);
            
       
    }
}
