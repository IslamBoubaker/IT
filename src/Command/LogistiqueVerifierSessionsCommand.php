<?php

namespace App\Command;

use App\Repository\SessionRepository;
use App\Entity\ChecklistLogistique;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'logistique:verifier-sessions',
    description: 'Déclenche la logistique si le seuil de stagiaires est atteint',
)]
class LogistiqueVerifierSessionsCommand extends Command
{
    private SessionRepository $sessionRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        SessionRepository $sessionRepository,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct();
        $this->sessionRepository = $sessionRepository;
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sessions = $this->sessionRepository->findSessionsAValider();
        $nb = 0;

        foreach ($sessions as $session) {
            if (count($session->getInscriptions()) >= $session->getMinParticipants()) {
                $checklist = new ChecklistLogistique();
                $checklist->setSession($session);
                $checklist->setEstActive(true);

                // ✅ Remplir la checklist complète
                $checklist->setSalleReservee(true);
                $checklist->setMachinesInstallees(true);
                $checklist->setSupportsImprimes(true);
                $checklist->setConvocationsEnvoyees(true); // à gérer selon ton entité

                $this->entityManager->persist($checklist);
                $nb++;
            }
        }

        $this->entityManager->flush();

        $output->writeln("✅ $nb session(s) validée(s) et checklist(s) générée(s).");

        return Command::SUCCESS;
    }
}
