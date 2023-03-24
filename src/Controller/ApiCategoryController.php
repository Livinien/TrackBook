<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiCategoryController extends AbstractController
{
    #[Route('/api/v1/category', name: 'app_api_category')]
    public function index(): Response
    {
        
    }
}