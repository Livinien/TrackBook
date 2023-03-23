<?php

namespace App\Controller\Admin;

use App\Entity\Box;
use App\Entity\Book;
use App\Entity\User;
use App\Entity\Borrow;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // COMMENTER LA LIGNE 22 POUR DÉCOMMENTER LA LIGNE 41 POUR ACÉDER À EASYADMIN
        // return parent::index(); 


        
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //

        

        // DÉCOMMENTER CETTE LIGNE POUR METTRE LA REDIRECTION DE L'ADMIN QUI SE SITUE DANS "ApiBookController.php" ET POUR ACCÉDER ENSUITE À EASYADMIN
        return $this->render('Admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('TrackBook');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Books', 'fas fa-book', Book::class);
        yield MenuItem::linkToCrud('Box', 'fas fa-box', Box::class);
        yield MenuItem::linkToCrud('Borrow', 'fa-solid fa-bookmark', Borrow::class);
        yield MenuItem::linkToCrud('Category', 'fa fa-rocket', Category::class);
    }
}