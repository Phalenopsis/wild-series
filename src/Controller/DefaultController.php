<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        $lastPrograms = $programRepository->findBy([], ['id' => 'DESC'], 5);

        $categories = $categoryRepository->findAll();
        return $this->render('index.html.twig',
        [
            'categories' => $categories,
            'last_programs' => $lastPrograms,
        ]);
    }

    #[Route('/my-profile', name: 'app_profil')]
    public function showProfil(): Response
    {
        return $this->render('home/index.html.twig');
    }
}