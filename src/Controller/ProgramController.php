<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

//#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/program/', name: 'program_index')]
    public function index(): Response
    {
        return $this->render('program/index.html.twig', [
            'website' => 'Wild Series',
        ]);
    }

    #[Route('/program/{id}', name: 'show', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function show(int $id = 1): Response
    {
        return $this->render('program/serie.html.twig', [
            'id' => $id
        ]);
    }
}