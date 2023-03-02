<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
Use App\Form\RegistrationFormType;
use App\Form\EdituserType;
use App\Form\EditProfileType;
use App\Form\AjouteruserType;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UserRepository;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[Route('/admin', name: 'admin_')]

class AdminController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        //   $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('base1.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    

    #[Route('/utlisateurs  ', name: 'utlisateurs')]
    public function afficherutlisateurs(SessionInterface $session): Response
    {
        $r=$this->getDoctrine()->getRepository(User::class);
        $users=$r->findAll();

        $numberOfUsers = $r->count([]);
        $session->set('numberOfUsers', $numberOfUsers);

        
        return $this->render('admin/users.html.twig', [
            'user' => $users,
            'numberOfUsers' => $numberOfUsers
            
        ]);           
    }

    #[Route('/admin/profile', name: 'profile')]
    
    public function profile(): Response
    {

        $user = $this->getUser();
        return $this->render('admin/profile.html.twig', [
            'user' => $user,
        
            
        ]);
    }

     #[Route('/utlisateurs/modifier/{id}  ', name: 'modifier_utlisateurs')]
       public function editUser(User $user, Request $request, TranslatorInterface $translator){
        $form = $this->createForm(EdituserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $message = $translator->trans('User modified successfully');

            $this->addFlash('message', $message);
            return $this->redirectToRoute('admin_utlisateurs');
        }

        return $this->render('admin/edituser.html.twig', [
            'userForm' => $form->createView()
        ]);
    }  
    #[Route('/utlisaturs/supprimer/{id}', name:'supprimer_utlisateurs')]
    public function suppClassroom(User $user,$id,UserRepository $r,ManagerRegistry $doctrine): Response
    {
        
        $user= $r->find($id);
         
        $em = $doctrine->getManager();
        $em->remove($user);

        $em->flush();

        return $this->redirectToRoute('admin_utlisateurs',);
    }

     #[Route('/utlisateurs/ajouter', name:'ajouter_utlisateurs')]
public function addClassroom(ManagerRegistry  $doctrine,Request $request):Response
{
    $user=new User();
    $form=$this->createForm(AjouteruserType::class,$user);
    $form->handleRequest($request);
    if($form->issubmitted()){
        $em=$doctrine->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('admin_utlisateurs');}
        return $this->renderForm("admin/adduser.html.twig",
        array("f"=>$form));
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
            return $this->redirectToRoute('admin_profile');
        }
        
        return $this->render('admin/editprofile.html.twig', [
            'Form' => $form->createView()
        ]);
            
       
    }


}
