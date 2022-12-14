<?php

namespace App\Controller\Blog;

use App\Entity\Post\Category;
use App\Repository\Post\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('/categories')]
class CategoryController extends AbstractController
{
    #[Route('/{slug}', name: 'category.index', methods: ['GET'])]
    public function index(Category $category, PostRepository $postRepository, Request $request): Response
    {
        // Pour la pagination
        $posts =  $postRepository->findpublished($request->query->getInt('page', 1), $category);

        return $this->render('pages/category/index.html.twig', [
            'category' => $category,
            'posts' => $posts
        ]);

    }
}