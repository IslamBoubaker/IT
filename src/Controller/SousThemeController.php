<?php

namespace App\Controller;

use App\Entity\SousTheme;
use App\Form\SousThemeType;
use App\Repository\SousThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sous/theme')]
final class SousThemeController extends AbstractController
{
    #[Route(name: 'app_sous_theme_index', methods: ['GET'])]
    public function index(SousThemeRepository $sousThemeRepository): Response
    {
        return $this->render('sous_theme/index.html.twig', [
            'sous_themes' => $sousThemeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sous_theme_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sousTheme = new SousTheme();
        $form = $this->createForm(SousThemeType::class, $sousTheme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sousTheme);
            $entityManager->flush();

            return $this->redirectToRoute('app_sous_theme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sous_theme/new.html.twig', [
            'sous_theme' => $sousTheme,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sous_theme_show', methods: ['GET'])]
    public function show(SousTheme $sousTheme): Response
    {
        return $this->render('sous_theme/show.html.twig', [
            'sous_theme' => $sousTheme,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sous_theme_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SousTheme $sousTheme, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SousThemeType::class, $sousTheme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sous_theme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sous_theme/edit.html.twig', [
            'sous_theme' => $sousTheme,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sous_theme_delete', methods: ['POST'])]
    public function delete(Request $request, SousTheme $sousTheme, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sousTheme->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sousTheme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sous_theme_index', [], Response::HTTP_SEE_OTHER);
    }
}
