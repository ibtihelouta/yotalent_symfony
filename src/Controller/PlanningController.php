<?php

namespace App\Controller;

use App\Entity\Planning;
use App\Form\PlanningType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evenement;
#[Route('/planning')]
class PlanningController extends AbstractController
{
   
    #[Route('/', name: 'app_planning_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $plannings = $entityManager
            ->getRepository(Planning::class)
            ->findAll();

        return $this->render('planning/index.html.twig', [
            'plannings' => $plannings,
        ]);
    }


    #[Route('/front', name: 'app_planning_front', methods: ['GET'])]
    public function front(EntityManagerInterface $entityManager): Response
    {
        $plannings = $entityManager
         ->getRepository(Planning::class)
            ->findAll();

        return $this->render('planning/indexFrontP.html.twig', [
            'plannings' => $plannings,
        ]);
    }
    

    #[Route('/new', name: 'app_planning_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        $planning = new Planning();
        $form = $this->createForm(PlanningType::class, $planning);
     
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
           
            $event=$entityManager
            ->getRepository(Evenement::class)
            ->find($planning->getIdev());
            $entityManager->persist($planning);
            $entityManager->flush();

            return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planning/new.html.twig', [
            'planning' => $planning,
            'form' => $form,
        ]);
    }
 #[Route('/{idp}', name: 'app_planning_show', methods: ['GET'])]
   
    public function show( Planning $planning): Response
    {
       
        return $this->render('planning/show.html.twig', [
            'planning' => $planning,
        ]);
    }
   

    #[Route('/{idp}/edit', name: 'app_planning_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Planning $planning, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planning/edit.html.twig', [
            'planning' => $planning,
            'form' => $form,
        ]);
    }

    #[Route('/{idp}', name: 'app_planning_delete', methods: ['POST'])]
    public function delete(Request $request, Planning $planning, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planning->getIdp(), $request->request->get('_token'))) {
            $entityManager->remove($planning);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_planning_index', [], Response::HTTP_SEE_OTHER);
    }
}
