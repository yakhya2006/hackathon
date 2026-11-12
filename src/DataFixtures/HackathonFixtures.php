<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;   // ← ajouté
use Doctrine\Persistence\ObjectManager;
use App\Entity\Hackathon;
use App\Entity\Organisateur;

class HackathonFixtures extends Fixture implements DependentFixtureInterface   // ← changé
{
    public function load(ObjectManager $manager): void
    {
        # fixtures

        $hackathons = [];

// create 5 hackathon with random dateHeureDebut
        for ($i = 0; $i < 5; $i++) {
            $hack = new Hackathon();
            $hack->setDateHeureDebut(new \DateTime());
            $hack->setDateHeureFin((new \DateTime())->modify('+2 days'));
            $orgaId = random_int(0, OrganisateurFixtures::NB_ORGA - 1);
            $orga = $this->getReference('organisateur_' . $orgaId, Organisateur::class);   // ← changé
            $hack->setOrganisateur($orga);
            $manager->persist($hack);
            $hackathons[] = $hack;
        }
        $manager->flush();
    }

    public function getDependencies(): array   // ← ajouté
    {
        return [OrganisateurFixtures::class];
    }
}
