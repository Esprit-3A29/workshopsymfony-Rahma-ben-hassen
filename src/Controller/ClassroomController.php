<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    #[Route('/listClassroom', name: 'list_Classroom')]
    public function listClassroom(ClassroomRepository $repository)
    {
        $Classroom= $repository->findAll();
       // $Classroom= $this->getDoctrine()->getRepository(ClassroomRepository::class)->findAll();
       return $this->render("Classroom/listClassroom.html.twig",array("tabClassroom"=>$Classroom));
    }

    #[Route('/addClassroom', name: 'add_Classroom')]
    public function addClassroom(ManagerRegistry $doctrine)
    {
        $Classroom= new Classroom();
        $Classroom->setId("2711");
        $Classroom->setName("symphony");
        
       // $em=$this->getDoctrine()->getManager();
        $em= $doctrine->getManager();
        $em->persist($Classroom);
        $em->flush();
        return $this->redirectToRoute("list_Classroom");
    }

    #[Route('/addForm', name: 'addClassroom')]
    public function addForm(ManagerRegistry $doctrine,Request $request)
    {
        $Classroom= new Classroom;
        $form= $this->createForm(ClassroomType::class,$Classroom);
        $form->handleRequest($request) ;
        if ($form->isSubmitted()){
             $em= $doctrine->getManager();
             $em->persist($Classroom);
             $em->flush();
             return  $this->redirectToRoute("list_Classroom");
         }
        return $this->renderForm("Classroom/add.html.twig",array("formClassroom"=>$form));
    }

    #[Route('/updateForm/{id}', name: 'update')]
    public function  updateForm($id,ClassroomRepository $repository,ManagerRegistry $doctrine,Request $request)
    {
        $Classroom= $repository->find($id);
        $form= $this->createForm(ClassroomType::class,$Classroom);
        $form->handleRequest($request) ;
        if ($form->isSubmitted()){
            $em= $doctrine->getManager();
            $em->flush();
            return  $this->redirectToRoute("list_Classroom");
        }
        return $this->renderForm("Classroom/update.html.twig",array("formClassroom"=>$form));
    }

    #[Route('/removeForm/{id}', name: 'remove')]

    public function removeClassroom(ManagerRegistry $doctrine,$id,ClassroomRepository $repository)
    {
        $Classroom= $repository->find($id);
        $em = $doctrine->getManager();
        $em->remove($Classroom);
        $em->flush();
        return  $this->redirectToRoute("list_Classroom");
    }
}
