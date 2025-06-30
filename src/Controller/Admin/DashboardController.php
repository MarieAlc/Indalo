<?php

namespace App\Controller\Admin;

use App\Entity\DureeConsommation;
use App\Entity\Materiel;
use App\Entity\PlanNettoyage;
use App\Entity\ProduitFabrication;
use App\Entity\ProduitTracabilite;
use App\Entity\Recurrence;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        $url = $adminUrlGenerator
            ->setController(ProduitFabricationCrudController::class)
            ->setAction('index')
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Indalo');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToCrud('Produits Fabrication', 'fas fa-box', ProduitFabrication::class);
        yield MenuItem::linkToCrud('Produits Traçabilité', 'fas fa-box-open', ProduitTracabilite::class);
        yield MenuItem::linkToCrud('Matériel', 'fas fa-tools', Materiel::class);
        yield MenuItem::linkToCrud('Durées Consommation', 'fas fa-clock', DureeConsommation::class);
        yield MenuItem::linkToCrud('Plans de Nettoyage', 'fas fa-broom', PlanNettoyage::class);
        yield MenuItem::linkToCrud('Récurrences', 'fas fa-sync', Recurrence::class);

        yield MenuItem::linkToRoute('Retour au site', 'fa fa-arrow-left', 'app_home');
    }
}
