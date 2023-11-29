<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    private const SEASONS = [
        ['program' => 'program_Walking dead', 'number' => 1, 'year' => 2010, 'description' => "Le shérif adjoint Rick Grimes se réveille d'un coma et cherche sa famille dans un monde ravagé par les morts-vivants."],
        ['program' => 'program_Walking dead', 'number' => 2, 'year' => 2011, 'description' => "The group's plan to head for Fort Benning is put on hold when Sophia goes missing."],
        ['program' => 'program_Walking dead', 'number' => 3, 'year' => 2012, 'description' => "After months on the run, the group take refuge in a federal prison, while elsewhere, Andrea's health starts to deteriorate."],

    ];
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        foreach (self::SEASONS as $seasonDescription) {
            $season = new Season();
            $season->setNumber($seasonDescription['number']);
            $season->setDescription($seasonDescription['description']);
            $season->setYear($seasonDescription['year']);
            $season->setProgram($this->getReference($seasonDescription['program']));
            $manager->persist($season);
            $this->addReference('season_'. $seasonDescription['number'], $season );
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
