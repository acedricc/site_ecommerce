<?php

namespace App\EventSubscriber;


use Twig\Environment;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DropdownCatSubcriber implements EventSubscriberInterface
{ 
    const ROUTES = ['app_home'];

    // public  function __construct(
    //     private CategorieRepository $categorieRepository,
    //     // private ProduitRepository $produitRepository,
    //     private Environment $twig
    // ) {    
    // }
    public function injectGlobalVariable(RequestEvent $event): void
    {
        dd($event->getRequest());
        // $route = $event->getRequest()->get('_route');
        // if (in_array($route, DropdownCatSubcriber::ROUTES)){
        //     $categories = $this->$categorieRepository->findAll();
        //     // $listeProduits = $produitRepository->findByMultipleAttributes($genre);
        //     $this->twig->addGlobal('allCategories', $categories);

        // }
       
    }

    public static function getSubscribedEvents()
    {
    return [KernelEvents::REQUEST => 'injectGlobalVariable'];
    }


}