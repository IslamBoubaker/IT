<?php

namespace App\Command;

use App\Entity\Inscription;
use App\Repository\SessionRepository;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'logistique:inscrire-stagiaire',
    description: 'Inscription d’un stagiaire à une session pour test logistique.',
)]
class LogistiqueInscrireStagiaireCommand extends Command
{
    public function __construct(
        private SessionRepository $sessionRepository,
        private StagiaireRepository $stagiaireRepository,
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sessionId = 1;    // ← à adapter selon tes données
        $stagiaireId = 1;  // ← idem

        $session = $this->sessionRepository->find($sessionId);
        $stagiaire = $this->stagiaireRepository->find($stagiaireId);

        if (!$session || !$stagiaire) {
            $output->writeln("❌ Session ou stagiaire introuvable (ID $sessionId / $stagiaireId)");
            return Command::FAILURE;
        }

        $inscription = new Inscription();
        $inscription->setSession($session);
        $inscription->setStagiaire($stagiaire);
        $inscription->setDateInscription(new \DateTime());
        $inscription->setStatut('inscrit');

        $this->entityManager->persist($inscription);
        $this->entityManager->flush();

        $output->writeln("✅ Stagiaire #{$stagiaireId} inscrit à la session #{$sessionId} ({$session->getIntitule()})");

        return Command::SUCCESS;
    }
}
