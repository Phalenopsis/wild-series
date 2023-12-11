<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;


class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    private const PROGRAMS = [
        ['title' => 'Walking dead', 'poster' => 'https://fr.web.img6.acsta.net/pictures/22/08/29/18/20/3648785.jpg', 'synopsis' => 'Des zombies envahissent la terre', 'category' => 'category_Action', 'country' => 'USA', 'year' => 2010],
        ['title' => 'La petite maison dans la prairie', 'poster' => 'https://img-3.journaldesfemmes.fr/zIVleRUPdxrbO_nHNYiM9AEN-uM=/1500x/smart/9cf0a53f1515486b974feb6ac6a31699/ccmcms-jdf/39475573.jpg', 'synopsis' => 'Des fermiers envahissent la terre', 'category' => 'category_Mièvre', 'country' => 'USA', 'year' => 1974],
        ['title' => 'Astro le petit Robot', 'poster' =>'https://www.manga-news.com/public/images/dvd/astroboy-1980-anime.jpg', 'synopsis' => 'Un petit robot sauve la terre', 'category' => 'category_Animation', 'country' => 'Japon', 'year' => 1980],
        ['title' => 'Goldorak', 'poster' => 'https://m.media-amazon.com/images/I/41aaedPHeQL._SY445_SX342_.jpg', 'synopsis' => 'Un gros robot sauve la terre', 'category' => 'category_Animation', 'country' => 'Japon', 'year' => 1975],
        ['title' => 'Friends', 'poster' => 'https://cdn.sortiraparis.com/images/80/66131/643118-serie-friends-l-episode-retrouvailles-avec-justin-bieber-et-lady-gaga-diffuse-le-27-mai.jpg', 'synopsis' => 'Des amis envahissent New York', 'category' => 'category_Comédie', 'country' => 'USA', 'year' => 1994],
        ['title' => 'All of us are dead', 'poster' => 'https://media-mcetv.ouest-france.fr/wp-content/uploads/2022/01/squid-game-une-actrice-de-la-serie-joue-aussi-dans-all-of-us-are-dead-1200-min.jpg', 'synopsis' => 'Des zombies envahissent Hyosan', 'category' => 'category_Horreur', 'country' => 'Coree', 'year' => 2022],

    ];

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
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
            $program->setPoster($programDescription['poster']);
            $program->setYear($programDescription['year']);
            $program->setCountry($programDescription['country']);
            $program->setCategory($this->getReference($programDescription['category']));
            $slug = $this->slugger->slug($program->getTitle());
            $program->setSlug($slug);
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

