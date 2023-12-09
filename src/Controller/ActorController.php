<?php

namespace App\Controller;

use App\Repository\ActorRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Actor;

#[Route('/actor', name: 'actor_')]
class ActorController extends AbstractController
{
    #[Route('/show/{id}', name: 'show')]
    public function show(Actor $actor): Response
    {
        return $this->render('actor/index.html.twig', [
            'controller_name' => 'ActorController',
            'actor' => $actor,
        ]);
    }

    #[Route('/show_actors_links/', name: 'show_actors_links', methods: ['GET'])]
    public function show_actor_links(ActorRepository $actorRepository): Response
    {
        $actors = $actorRepository->findAll();
        return $this->render('actor/_actors_links.html.twig', [
            'actors_links' => $actors,
        ]);
    }
}
