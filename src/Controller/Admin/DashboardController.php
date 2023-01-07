<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\CategoryCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;


class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
        
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $url = $this->adminUrlGenerator->setController(CategoryCrudController::class)->generateUrl();
        return $this->redirect($url);
        // return $this->redirect($adminUrlGenerator->setController(Product::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('E Commerce');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Catégories');
        yield MenuItem::subMenu('Action','fas fa-bars')->setSubitems([
            MenuItem::linkToCrud('Ajouter une catégorie','fas fa-plus',Category::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les catégories','fas fa-eye',Category::class)
        ]);

        yield MenuItem::section('Produits');
        yield MenuItem::subMenu('Action','fas fa-bars')->setSubitems([
            MenuItem::linkToCrud('Ajouter un produit','fas fa-plus',Product::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Afficher les produits','fas fa-eye',Product::class)
        ]);


        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
