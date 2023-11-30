<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/show/{categoryName}', name: 'show', methods: ['GET'])]
    public function show(string $categoryName, ProgramRepository $programRepository, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findByName([$categoryName])[0];
        $programs = $programRepository->findBy(
            ['category' => $category->getId()],
            ['id' => 'DESC'],
            3
        );

        if(!$programs){
            throw $this->createNotFoundException(
                'No program with id : ' . $categoryName . ' found in category\'s table.'
            );
        }

        return $this->render('category/show.html.twig', [
            'categoryName' => $categoryName,
            'programs' => $programs,
        ]);
    }

    #[Route('/show_categories_links/', name: 'show_categories_links', methods: ['GET'])]
    public function show_category_links(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/_categories_links.html.twig', [
            'categories_links' => $categories,
        ]);
    }

}