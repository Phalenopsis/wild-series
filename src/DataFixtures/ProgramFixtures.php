<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    private const PROGRAMS = [
        ['title' => 'Walking dead', 'synopsis' => 'Des zombies envahissent la terre', 'category' => 'category_Action', 'country' => 'USA', 'year' => 2010],
        ['title' => 'La petite maison dans la prairie', 'synopsis' => 'Des fermiers envahissent la terre', 'category' => 'category_Mièvre', 'country' => 'USA', 'year' => 1974],
        ['title' => 'Astro le petit Robot', 'synopsis' => 'Un petit robot sauve la terre', 'category' => 'category_Animation', 'country' => 'Japon', 'year' => 1980],
        ['title' => 'Goldorak', 'synopsis' => 'Un gros robot sauve la terre', 'category' => 'category_Animation', 'country' => 'Japon', 'year' => 1975],
        ['title' => 'Friends', 'synopsis' => 'Des amis envahissent New York', 'category' => 'category_Comédie', 'country' => 'USA', 'year' => 1994],
        ['title' => 'All of us are dead', 'synopsis' => 'Des zombies envahissent Hyosan', 'category' => 'category_Horreur', 'country' => 'Coree', 'year' => 2022],

    ];
    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::PROGRAMS as $programDescription) {
            $program = new Program();
            $program->setTitle($programDescription['title']);
            $program->setSynopsis($programDescription['synopsis']);
            $program->setYear($programDescription['year']);
            $program->setCountry($programDescription['country']);
            $program->setCategory($this->getReference($programDescription['category']));
            $manager->persist($program);
            $this->addReference('program_' . $programDescription['title'], $program);
        }
        $manager->flush();
    }

    static function getTitles(): array
    {
        return array_map(fn ($arr) => $arr['title'], self::PROGRAMS);
    }
}

