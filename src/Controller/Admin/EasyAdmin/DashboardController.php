<?php

namespace App\Controller\Admin\EasyAdmin;

use App\Entity\Categorie;
use App\Entity\Commande;
use App\Entity\Detail;
use App\Entity\Genre;
use App\Entity\Produit;
use App\Entity\Taille;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;


class DashboardController extends AbstractDashboardController
{

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Site Ecomerce - Administration')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa-solid fa-users', User::class );
        yield MenuItem::linkToCrud('Tailles', 'fa-solid fa-maximize', Taille::class );
        yield MenuItem::linkToCrud('Produits', 'fa-solid fa-shirt', Produit::class );
        yield MenuItem::linkToCrud('Genres', 'fa-solid fa-restroom', Genre::class );
        yield MenuItem::linkToCrud('Détails', 'fa-solid fa-file-lines', Detail::class );
        yield MenuItem::linkToCrud('Commandes', 'fa-solid fa-truck-fast', Commande::class );
        yield MenuItem::linkToCrud('Catégories', 'fa-solid fa-bars', Categorie::class );




       


        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
