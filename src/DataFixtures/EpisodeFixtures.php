<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private const EPISODES = [
        ['season' => 'season_1', 'title' => 'Days Gone Bye', 'number' => 1, 'synopsis' => "Le shérif adjoint Rick Grimes se réveille d'un coma et cherche sa famille dans un monde ravagé par les morts-vivants."],
        ['season' => 'season_1', 'title' => 'Guts', 'number' => 2, 'synopsis' => "In Atlanta, Rick is rescued by a group of survivors, but they soon find themselves trapped inside a department store surrounded by walkers."],
        ['season' => 'season_1', 'title' => 'Tell It to the Frogs', 'number' => 3, 'synopsis' => "Rick is reunited with Lori and Carl but soon decides - along with some of the other survivors - to return to the rooftop and rescue Merle. Meanwhile, tensions run high between the other survivors at the camp."],
        ['season' => 'season_2', 'title' => 'What Lies Ahead', 'number' => 1, 'synopsis' => "The group's plan to head for Fort Benning is put on hold when Sophia goes missing."],
        ['season' => 'season_2', 'title' => 'Bloodletting', 'number' => 2, 'synopsis' => "After Carl is accidentally shot, the group are brought to a family living on a nearby farm. Shane makes a dangerous trip in search of medical supplies."],
        ['season' => 'season_2', 'title' => 'Save the Last One', 'number' => 3, 'synopsis' => "As Carl's condition continues to deteriorate, Shane and Otis try to dodge the walkers as they head back to the farm."],
        ['season' => 'season_3', 'title' => 'Seed', 'number' => 1, 'synopsis' => "After months on the run, the group take refuge in a federal prison, while elsewhere, Andrea's health starts to deteriorate."],
        ['season' => 'season_3', 'title' => 'Sick', 'number' => 2, 'synopsis' => "As Hershel's condition worsens, Rick, Daryl and T-Dog deal with a group of prisoners."],
        ['season' => 'season_3', 'title' => 'Walk with Me', 'number' => 3, 'synopsis' => "Andrea and Michonne are brought to a walled community run by a man called The Governor."],

    ];

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        foreach (self::EPISODES as $episodeDescription){
            $episode = new Episode();
            $episode->setNumber($episodeDescription['number']);
            $episode->setTitle($episodeDescription['title']);
            $episode->setSynopsis($episodeDescription['synopsis']);
            $episode->setSeason($this->getReference($episodeDescription['season']));
            $manager->persist($episode);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
          SeasonFixtures::class,
        ];
    }
}
