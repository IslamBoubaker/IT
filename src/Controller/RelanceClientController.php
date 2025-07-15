<?php

namespace App\Controller;

use App\Entity\RelanceClient;
use App\Form\RelanceClientType;
use App\Repository\RelanceClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/relance/client')]
final class RelanceClientController extends AbstractController
{
    #[Route(name: 'app_relance_client_index', methods: ['GET'])]
    public function index(RelanceClientRepository $relanceClientRepository): Response
    {
        return $this->render('relance_client/index.html.twig', [
            'relance_clients' => $relanceClientRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_relance_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $relanceClient = new RelanceClient();
        $form = $this->createForm(RelanceClientType::class, $relanceClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($relanceClient);
            $entityManager->flush();

            return $this->redirectToRoute('app_relance_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('relance_client/new.html.twig', [
            'relance_client' => $relanceClient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_relance_client_show', methods: ['GET'])]
    public function show(RelanceClient $relanceClient): Response
    {
        return $this->render('relance_client/show.html.twig', [
            'relance_client' => $relanceClient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_relance_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RelanceClient $relanceClient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RelanceClientType::class, $relanceClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_relance_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('relance_client/edit.html.twig', [
            'relance_client' => $relanceClient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_relance_client_delete', methods: ['POST'])]
    public function delete(Request $request, RelanceClient $relanceClient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$relanceClient->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($relanceClient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_relance_client_index', [], Response::HTTP_SEE_OTHER);
    }
}
