<?php

namespace App\Controller\Blog;

use App\Entity\Post\Post;
use App\Repository\Post\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    #[Route('/', name: 'app_post', methods:['GET'])]
    public function index(PostRepository $postRepository, PaginatorInterface $paginator, Request $request): Response
    {

        // We could use the method findby but we'll use a custom method created in postRepository
        // It would be more efficient if we want to call this method in other controllers and maintain this method
        $data = $postRepository->findpublished();

        // pagination system with KnpPaginatorBundle
        $posts = $paginator->paginate( $data, $request->query->getInt('page', 1), /*page number*/ 9 /*limit per page*/
    );


        return $this->render('pages/blog/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}
