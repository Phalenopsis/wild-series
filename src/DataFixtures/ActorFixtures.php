<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;


class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i < 10; $i++){
            $programs = ProgramFixtures::getTitles();
            $programsRandKeys = array_rand($programs, 3);
            $actor = new Actor();
            $actor->setFirstname($faker->firstName());
            $actor->setLastname($faker->lastName());
            $slug = $this->slugger->slug($actor->getFirstname() . ' ' . $actor->getLastname());
            $actor->setSlug($slug);
            $actor->setBirthdate($faker->dateTimeBetween('-80 year', '-10 year'));
            foreach ($programsRandKeys as $key){
                $actor->addProgram($this->getReference('program_' . $programs[$key]));
            }
            $manager->persist($actor);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            ProgramFixtures::class,
        ];
    }
}
