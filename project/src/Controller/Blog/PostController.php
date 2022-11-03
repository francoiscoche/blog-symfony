<?php

namespace App\Controller\Blog;

use App\Entity\Post\Post;
use App\Repository\Post\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/', name: 'app_post', methods:['GET'])]
    public function index(PostRepository $postRepository): Response
    {

        // We could use the method findby but we'll use a custom method created in postRepository
        // It would be more efficient if we want to call this method in other controllers and maintain this method
        $posts = $postRepository->findpublished();


        return $this->render('pages/blog/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}
