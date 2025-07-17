<?php

namespace App\Command;

use App\Entity\Alerte;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'logistique:generer-alertes',
    description: 'Génère des alertes pour les sessions à J-15 qui n’ont pas atteint leur seuil.',
)]
class LogistiqueGenererAlertesCommand extends Command
{
    public function __construct(
        private SessionRepository $sessionRepository,
        private EntityManagerInterface $em
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $limite = new \DateTime('+15 days');
        $sessions = $this->sessionRepository->findSessionsAvant($limite);
        $nb = 0;

        foreach ($sessions as $session) {
            $inscrits = count($session->getInscriptions());
            if ($inscrits < $session->getSeuilMinimum()) {
                $alerte = new Alerte();
                $alerte->setSession($session);
                $alerte->setNiveau('avertissement');
                $alerte->setMessage("⚠️ Attention : la session '{$session->getIntitule()}' prévue le " . $session->getDate()->format('d/m/Y') . " n'a que $inscrits inscrit(s) (seuil requis : {$session->getSeuilMinimum()}).");

                $this->em->persist($alerte);
                $nb++;
            }
        }

        $this->em->flush();
        $output->writeln("📣 $nb alerte(s) générée(s) pour sessions en dessous du seuil à J-15.");

        return Command::SUCCESS;
    }
}
