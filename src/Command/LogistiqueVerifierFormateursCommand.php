<?php

namespace App\Command;

use App\Entity\Alerte;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'logistique:verifier-formateurs',
    description: 'Valide les formateurs nouveaux intervenants J-21 avant la session',
)]
class LogistiqueVerifierFormateursCommand extends Command
{
    public function __construct(
        private SessionRepository $sessionRepository,
        private EntityManagerInterface $em
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dateLimite = new \DateTime('+21 days');
        $sessions = $this->sessionRepository->findSessionsAvant($dateLimite);

        $nb = 0;

        foreach ($sessions as $session) {
    $formateur = $session->getFormateur();

    if ($formateur !== null && !$formateur->isDejaValide()) {
        $alerte = new Alerte();
        $alerte->setMessage("⚠️ Le formateur « {$formateur->getNom()} » doit être validé avant la session du {$session->getDate()->format('d/m/Y')}");
        // $alerte->setType('validation_formateur');
        $alerte->setSession($session);
        $this->em->persist($alerte);
        $nb++;
    }
}

        $this->em->flush();
        $output->writeln("✅ $nb alerte(s) générée(s) pour validation des formateurs.");
        return Command::SUCCESS;
    }
}