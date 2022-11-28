<?php

namespace App\EventSubscriber;

use App\Repository\Post\CategoryRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;


/**
 * Permet de récuperer les catégories et d'ajouter a liste en variable global pour etre utilisé uniquement pour les routes index et categories
 */
class DropdownCategoriesSubscriber implements EventSubscriberInterface 
{
    const ROUTES = ['app_post', 'category.index'];

    public function __construct(private CategoryRepository $categoryRespository,
                                private Environment $twig   // Pour ajouter une variable global
    )
    {
        
    }

    public function injectGlobalVariable(RequestEvent $event):void 
    {
        $route = $event->getRequest()->get('_route');
        if(in_array($route, DropdownCategoriesSubscriber::ROUTES))
        {
            $categories = $this->categoryRespository->findAll();
            $this->twig->addGlobal('allCategories', $categories);  // On ajoute notre vairiable global
        }
    }

    public static function getSubscribedEvents()
    {
        // On retourne les evnt auquel on es abonné
        return [KernelEvents::REQUEST  => 'injectGlobalVariable'];
    }
}