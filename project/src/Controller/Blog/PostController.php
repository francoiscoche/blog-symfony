<?php

namespace App\Controller\Blog;

use App\Entity\Post\Post;
use App\Form\SearchType;
use App\Model\SearchData;
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

        $searchData = new SearchData();

        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $searchData->page = $request->query->getInt('page', 1);
            $posts = $postRepository->findBySearch($searchData);

            return $this->render('pages/post/index.html.twig', [
                'posts' => $posts,
                'form' => $form->createView()
            ]);
            
        }

        // We could use the method findby but we'll use a custom method created in postRepository
        // It would be more efficient if we want to call this method in other controllers and maintain this method
        $posts = $postRepository->findpublished($request->query->getInt('page', 1));

        return $this->render('pages/post/index.html.twig', [
            'posts' => $posts,
            'form' => $form->createView()
        ]);
    }


    #[Route('/article/{slug}', name: 'app_show', methods: ['GET'])]
    public function show(Post $post, string $slug = null): Response
    {
        // $post = $postRepository->findOneBy(["slug" => $slug]);
        return $this->render('pages/post/show.html.twig', [
            'post' => $post,
        ]);
    }
}
