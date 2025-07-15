<?php

namespace App\Controller;

use App\Entity\ChecklistLogistique;
use App\Form\ChecklistLogistiqueType;
use App\Repository\ChecklistLogistiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/checklist/logistique')]
final class ChecklistLogistiqueController extends AbstractController
{
    #[Route(name: 'app_checklist_logistique_index', methods: ['GET'])]
    public function index(ChecklistLogistiqueRepository $checklistLogistiqueRepository): Response
    {
        return $this->render('checklist_logistique/index.html.twig', [
            'checklist_logistiques' => $checklistLogistiqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_checklist_logistique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $checklistLogistique = new ChecklistLogistique();
        $form = $this->createForm(ChecklistLogistiqueType::class, $checklistLogistique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($checklistLogistique);
            $entityManager->flush();

            return $this->redirectToRoute('app_checklist_logistique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('checklist_logistique/new.html.twig', [
            'checklist_logistique' => $checklistLogistique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_checklist_logistique_show', methods: ['GET'])]
    public function show(ChecklistLogistique $checklistLogistique): Response
    {
        return $this->render('checklist_logistique/show.html.twig', [
            'checklist_logistique' => $checklistLogistique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_checklist_logistique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ChecklistLogistique $checklistLogistique, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChecklistLogistiqueType::class, $checklistLogistique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_checklist_logistique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('checklist_logistique/edit.html.twig', [
            'checklist_logistique' => $checklistLogistique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_checklist_logistique_delete', methods: ['POST'])]
    public function delete(Request $request, ChecklistLogistique $checklistLogistique, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$checklistLogistique->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($checklistLogistique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_checklist_logistique_index', [], Response::HTTP_SEE_OTHER);
    }
}
