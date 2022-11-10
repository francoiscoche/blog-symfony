<?php

namespace App\Controller\Blog;

use App\Entity\Post\Post;
use App\Repository\Post\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractController
{
    #[Route('/', name: 'app_post', methods:['GET'])]
    public function index(PostRepository $postRepository, Request $request): Response
    {
        // We could use the method findby but we'll use a custom method created in postRepository
        // It would be more efficient if we want to call this method in other controllers and maintain this method
        $posts = $postRepository->findpublished($request->query->getInt('page', 1));

        return $this->render('pages/blog/index.html.twig', [
            'posts' => $posts,
        ]);
    }


    #[Route('/article/{slug}', name: 'app_show', methods: ['GET'])]
    public function show(Post $post, string $slug = null): Response
    {
        // $post = $postRepository->findOneBy(["slug" => $slug]);
        return $this->render('pages/blog/show.html.twig', [
            'post' => $post,
        ]);
    }
}
