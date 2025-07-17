<?php

namespace App\Controller;

use App\Repository\AlerteRepository;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * Dashboard principal
     */
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(SessionRepository $sessionRepo, AlerteRepository $alerteRepo): Response
    {
        $sessionsPlanifiees = $sessionRepo->count(['etat' => 'planifiee']);
        $alertesCritiques = $alerteRepo->count(['niveau' => 'critique']);

        // Taux de remplissage moyen (pour sessions avec un minimum défini)
        $sessions = $sessionRepo->findAll();
        $taux = 0;
        $total = 0;

        foreach ($sessions as $session) {
            $min = $session->getMinParticipants();
            if ($min > 0) {
                $taux += min(1, $session->getInscriptions()->count() / $min);
                $total++;
            }
        }

        $tauxMoyen = $total > 0 ? round(($taux / $total) * 100) : 0;

        // Prochaine session
        $prochaineSession = $sessionRepo->createQueryBuilder('s')
            ->where('s.date > :now')
            ->setParameter('now', new \DateTimeImmutable())
            ->orderBy('s.date', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $this->render('dashboard/index.html.twig', [
            'sessionsPlanifiees' => $sessionsPlanifiees,
            'alertesCritiques' => $alertesCritiques,
            'tauxRemplissage' => $tauxMoyen,
            'prochaineSession' => $prochaineSession,
        ]);
    }

    /**
     * Liste des alertes avec filtre par session
     */
    #[Route('/dashboard/alertes', name: 'dashboard_alertes')]
    public function alertes(Request $request, AlerteRepository $alerteRepository, SessionRepository $sessionRepository): Response
    {
        $sessionId = $request->query->get('session');
        $alertes = $sessionId
            ? $alerteRepository->findBy(['session' => $sessionId], ['id' => 'DESC'])
            : $alerteRepository->findBy([], ['id' => 'DESC']);

        $sessions = $sessionRepository->findAll();

        return $this->render('dashboard/alertes.html.twig', [
            'alertes' => $alertes,
            'sessions' => $sessions,
        ]);
    }

    /**
     * Export CSV des alertes
     */
    #[Route('/dashboard/alertes/export', name: 'dashboard_alertes_export')]
    public function exportAlertes(Request $request, AlerteRepository $alerteRepo): StreamedResponse
    {
        $sessionId = $request->query->get('session');
        $alertes = $sessionId
            ? $alerteRepo->findBy(['session' => $sessionId])
            : $alerteRepo->findAll();

        $response = new StreamedResponse(function () use ($alertes) {
            $handle = fopen('php://output', 'w');

            // En-têtes CSV
            fputcsv($handle, ['ID', 'Message', 'Session', 'Date de création']);

            foreach ($alertes as $alerte) {
                fputcsv($handle, [
                    $alerte->getId(),
                    $alerte->getMessage(),
                    $alerte->getSession() ? $alerte->getSession()->getIntitule() : 'N/A',
                    $alerte->getCreatedAt()?->format('d/m/Y H:i') ?? '-',
                ]);
            }

            fclose($handle);
        });

        $filename = 'export_alertes_' . date('Ymd_His') . '.csv';
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
