<?php

namespace App\Controller;

use App\Entity\Alerte;
use App\Repository\ChecklistLogistiqueRepository;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/logistique')]
class LogistiqueController extends AbstractController
{
    #[Route('/dashboard', name: 'logistique_dashboard')]
    public function dashboard(SessionRepository $sessionRepository): Response
    {
        return $this->render('logistique/dashboard.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }

#[Route('/alertes', name: 'logistique_alertes')]
public function alertes(EntityManagerInterface $em): Response
{
    $alertes = $em->getRepository(\App\Entity\Alerte::class)->findBy([
        'estTraitee' => false
    ]);

    return $this->render('logistique/alertes.html.twig', [
        'alertes' => $alertes,
    ]);
}
#[Route('/valider-formateur/{id}', name: 'logistique_valider_formateur')]
public function validerFormateur(int $id, EntityManagerInterface $em): Response
{
    $alerte = $em->getRepository(Alerte::class)->find($id);

    if (!$alerte) {
        throw $this->createNotFoundException('Alerte introuvable.');
    }

    $formateur = $alerte->getSession()->getFormateur();
    $formateur->setDejaValide(true);

    $alerte->setEstTraitee(true);

    $em->flush();

    $this->addFlash('success', "✅ Le formateur {$formateur->getNom()} a été validé.");

    return $this->redirectToRoute('logistique_alertes');
}
    #[Route('/logistique/checklists', name: 'logistique_checklists')]
    public function checklists(ChecklistLogistiqueRepository $repo): Response
    {
        $checklists = $repo->findBy([], ['id' => 'DESC']);

        return $this->render('logistique/checklists.html.twig', [
            'checklists' => $checklists,
        ]);
    }
}