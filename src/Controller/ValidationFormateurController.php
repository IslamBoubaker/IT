<?php

namespace App\Controller;

use App\Entity\FormateurValidation;
use App\Form\FormateurValidationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ValidationFormateurController extends AbstractController
{
    #[Route('/validation-formateur', name: 'app_validation_formateur')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $validation = new FormateurValidation();
        $form = $this->createForm(FormateurValidationType::class, $validation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $validation = $form->getData();

            // Vérifie si la validation est bien prévue 3 semaines à l'avance
            $now = new \DateTime();
            $threeWeeksLater = (clone $now)->modify('+3 weeks');
            if ($validation->getDateValidation() < $threeWeeksLater) {
                $this->addFlash('error', 'La validation doit être planifiée au moins 3 semaines à l’avance.');
            } else {
                $em->persist($validation);
                $em->flush();
                $this->addFlash('success', 'Validation enregistrée.');
                return $this->redirectToRoute('app_validation_formateur');
            }
        }

        return $this->render('validation_formateur/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
}
