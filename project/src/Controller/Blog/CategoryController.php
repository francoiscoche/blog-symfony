<?php

namespace App\Controller\Blog;

use App\Model\SearchData;
use App\Form\SearchType;
use App\Entity\Post\Category;
use App\Repository\Post\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/categories')]
class CategoryController extends AbstractController
{
    #[Route('/{slug}', name: 'category.index', methods: ['GET'])]
    public function index(Category $category, PostRepository $postRepository, Request $request): Response
    {
        // Pour la pagination
        // $posts =  $postRepository->findpublished($request->query->getInt('page', 1), $category);

        $searchData = new SearchData();

        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $searchData->page = $request->query->getInt('page', 1);
            $posts = $postRepository->findBySearch($searchData);

            return $this->render('pages/post/index.html.twig', [
                'posts' => $posts,
                'category' => $category,
                'form' => $form->createView()
            ]);

        }

        // We could use the method findby but we'll use a custom method created in postRepository
        // It would be more efficient if we want to call this method in other controllers and maintain this method
        $posts = $postRepository->findpublished($request->query->getInt('page', 1));

        return $this->render('pages/category/index.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
            'posts' => $posts
        ]);
    }
}