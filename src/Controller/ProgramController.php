<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Repository\SeasonRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();


        return $this->render('program/index.html.twig', [
            'programs' => $programs,
        ]);
    }

    #[Route('/show/{id}', name: 'show', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function show(Program $program): Response
    {
        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/show/{programId}/seasons/{seasonId}', name: 'season_show', requirements: ['programId'=>'\d+', 'seasonId'=>'\d+'], methods: ['GET'])]
    public function showSeason(
        #[MapEntity(mapping: ['programId' => 'id'])] Program $program,
        #[MapEntity(mapping: ['seasonId' => 'id'])] Season $season
        ): Response
    {
        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
        ]);
    }

    #[Route('/show/{programId}/seasons/{seasonId}/episode/{episodeId}', name: 'episode_show')]
    public function showEpisode(#[MapEntity(mapping: ['programId' => 'id'])] Program $program,
                                #[MapEntity(mapping: ['seasonId' => 'id'])] Season $season,
                                #[MapEntity(mapping: ['episodeId' => 'id'])] Episode $episode):Response
    {
        return $this->render('program/episode_show.html.twig',[
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
        ]);
    }
}