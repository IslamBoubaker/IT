<?php

namespace App\Command;

use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'logistique:annuler-sessions',
    description: 'Annule automatiquement les sessions dont le seuil minimum n’est pas atteint à J-15.',
)]
class LogistiqueAnnulerSessionsCommand extends Command
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
        $sessions = $this->sessionRepository->findSessionsPourAnnulation();
        $nb = 0;

        foreach ($sessions as $session) {
            $nbInscrits = count($session->getInscriptions());

            if ($nbInscrits < $session->getSeuilMinimum() && $session->getEtat() !== 'Annulée') {
                $session->setEtat('Annulée');
                $this->entityManager->persist($session);
                $nb++;
            }
        }

        $this->entityManager->flush();
        $output->writeln("❌ $nb session(s) automatiquement annulée(s).");

        return Command::SUCCESS;
    }
}
