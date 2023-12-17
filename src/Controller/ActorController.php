<?php

namespace App\Controller;

use App\Form\ActorType;
use App\Repository\ActorRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Actor;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/actor', name: 'actor_')]
class ActorController extends AbstractController
{
    #[Route('/show/{slug}', name: 'show')]
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

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $actor = new Actor();
        $form = $this->createForm(ActorType::class, $actor);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $slug = $slugger->slug($actor->getFirstname() . ' ' . $actor->getLastname());
            $actor->setSlug($slug);
            $entityManager->persist($actor);
            $entityManager->flush();
            $this->addFlash('success', 'the new actor has been created');
            return $this->redirectToRoute('app_index');
        }

        return $this->render('actor/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/edit/{slug}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Actor $actor, EntityManagerInterface $entityManager, SluggerInterface $slugger) : Response
    {
        $form = $this->createForm( ActorType::class, $actor);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $slug = $slugger->slug($actor->getFirstname() . ' ' . $actor->getLastname());
            $actor->setSlug($slug);

            $entityManager->flush();
            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('actor/edit.html.twig', [
            'actor' => $actor,
            'form' => $form,
        ]);
    }

    #[Route('delete/{slug}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Actor $actor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actor->getId(), $request->request->get('_token'))) {
            $entityManager->remove($actor);
            $entityManager->flush();
            $this->addFlash('danger', 'The actor has been deleted');
        }
        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }
}
