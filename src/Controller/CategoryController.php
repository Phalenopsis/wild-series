<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategoryType;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

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

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager) : Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            // Redirect to categories list
            return $this->redirectToRoute('category_index');
        }

        // Render the form
        return $this->render('category/new.html.twig', [
            'form' => $form,
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