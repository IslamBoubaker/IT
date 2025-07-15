<?php

namespace App\Controller;

use App\Entity\MonitoringSession;
use App\Form\MonitoringSessionType;
use App\Repository\MonitoringSessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/monitoring/session')]
final class MonitoringSessionController extends AbstractController
{
    #[Route(name: 'app_monitoring_session_index', methods: ['GET'])]
    public function index(MonitoringSessionRepository $monitoringSessionRepository): Response
    {
        return $this->render('monitoring_session/index.html.twig', [
            'monitoring_sessions' => $monitoringSessionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_monitoring_session_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $monitoringSession = new MonitoringSession();
        $form = $this->createForm(MonitoringSessionType::class, $monitoringSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($monitoringSession);
            $entityManager->flush();

            return $this->redirectToRoute('app_monitoring_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('monitoring_session/new.html.twig', [
            'monitoring_session' => $monitoringSession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_monitoring_session_show', methods: ['GET'])]
    public function show(MonitoringSession $monitoringSession): Response
    {
        return $this->render('monitoring_session/show.html.twig', [
            'monitoring_session' => $monitoringSession,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_monitoring_session_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MonitoringSession $monitoringSession, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MonitoringSessionType::class, $monitoringSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_monitoring_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('monitoring_session/edit.html.twig', [
            'monitoring_session' => $monitoringSession,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_monitoring_session_delete', methods: ['POST'])]
    public function delete(Request $request, MonitoringSession $monitoringSession, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$monitoringSession->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($monitoringSession);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_monitoring_session_index', [], Response::HTTP_SEE_OTHER);
    }
}
