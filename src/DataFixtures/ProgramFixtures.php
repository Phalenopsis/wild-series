<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    private const PROGRAMS = [
        ['title' => 'Walking dead', 'synopsis' => 'Des zombies envahissent la terre', 'category' => 'category_Action'],
        ['title' => 'La petite maison dans la prairie', 'synopsis' => 'Des fermiers envahissent la terre', 'category' => 'category_Mièvre'],
        ['title' => 'Astro le petit Robot', 'synopsis' => 'Un petit robot sauve la terre', 'category' => 'category_Animation'],
        ['title' => 'Goldorak', 'synopsis' => 'Un gros robot sauve la terre', 'category' => 'category_Animation'],
        ['title' => 'Friends', 'synopsis' => 'Des amis envahissent New York', 'category' => 'category_Comédie'],

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
            $program->setCategory($this->getReference($programDescription['category']));
            $manager->persist($program);
        }
        $manager->flush();
    }
}

