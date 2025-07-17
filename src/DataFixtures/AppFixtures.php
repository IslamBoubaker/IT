<?php

namespace App\DataFixtures;

use App\Entity\Formateur;
use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Entity\Inscription;
use App\Entity\ChecklistLogistique;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use DateInterval;
use DateTimeImmutable;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $formateurs = [];

        // 🔹 1. Création des formateurs
        for ($i = 0; $i < 5; $i++) {
            $formateur = (new Formateur())
                ->setNom(ucfirst($faker->lastName()))
                ->setPrenom(ucfirst($faker->firstName()))
                ->setEmail(strtolower($faker->email()));

            $manager->persist($formateur);
            $formateurs[] = $formateur;
        }

        // 🔹 2. Création de 3 sessions (avec seuil minimum)
        $sessions = [];
        for ($i = 0; $i < 3; $i++) {
            $dateDebut = (new DateTimeImmutable())->add(new DateInterval('P' . (15 + $i * 3) . 'D'));
            $session = (new Session())
                ->setDate(\DateTime::createFromImmutable($dateDebut))
                ->setEtat('planifiee')
                ->setIntitule('Session ' . ($i + 1))
                ->setPrix($faker->randomFloat(2, 300, 1000))
                ->setMinParticipants(3)
                ->setSeuilMinimum(3)
                ->setStatut('en_attente')
                ->setFormateur($faker->randomElement($formateurs));

            $manager->persist($session);
            $sessions[] = $session;
        }

        // 🔹 3. Création de stagiaires + inscriptions à ces sessions
        foreach ($sessions as $session) {
            $nbStagiaires = random_int(2, 4); // Certains atteignent le seuil

            for ($i = 0; $i < $nbStagiaires; $i++) {
                $stagiaire = (new Stagiaire())
                    ->setNom(ucfirst($faker->lastName()))
                    ->setPrenom(ucfirst($faker->firstName()))
                    ->setEmail(strtolower($faker->email()));

                $manager->persist($stagiaire);

                $inscription = (new Inscription())
                    ->setStagiaire($stagiaire)
                    ->setSession($session)
                    ->setDateInscription(new DateTimeImmutable())
                    ->setStatut('inscrit');

                $manager->persist($inscription);
            }
        }

        $manager->flush(); // 🔄 Nécessaire pour que les sessions aient leurs ID

        // 🔹 4. Génération automatique des checklists si seuil atteint
        foreach ($sessions as $session) {
            if ($session->getInscriptions()->count() >= $session->getSeuilMinimum()) {
                $checklist = (new ChecklistLogistique())
                    ->setSession($session)
                    ->setDateGeneration(new DateTimeImmutable());

                $manager->persist($checklist);
            }
        }

        // 🔹 5. Session spéciale (J-10) sans stagiaires pour générer une alerte
        $sessionTest = (new Session())
            ->setDate(\DateTime::createFromImmutable((new DateTimeImmutable())->add(new DateInterval('P10D'))))
            ->setEtat('Planifiée')
            ->setIntitule('Session Test Alerte')
            ->setPrix(450)
            ->setMinParticipants(3)
            ->setSeuilMinimum(3)
            ->setStatut('en_attente')
            ->setFormateur($faker->randomElement($formateurs));

        $manager->persist($sessionTest);

        $manager->flush(); // ✅ Flush final
    }
}
