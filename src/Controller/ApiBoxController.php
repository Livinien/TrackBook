<?php

namespace App\Controller;

use App\Repository\BoxRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiBoxController extends AbstractController
{
   
    // REQUÊTE GET DES LBOX POUR RÉCUPÉRER LES BOX

    #[Route('/api/v1/box', name: 'app_api_box_get', methods: "GET")]
    
    public function boxGet(BoxRepository $boxRepository, SerializerInterface $serializer): Response
    {

        // Factoriser la Sérialization
        // return $this->json($bookRepository->findAll(), 200, []);

        // Processus de Sérialization
        $box = $boxRepository->findAll();
        
        // Faire les groupes
        $json = $serializer->serialize($box, 'json');

        $response = new JsonResponse($json, 200, [], true);

        return $response; 
        
        // Sérialization : On part d'un objet ou d'un tableau associatif PHP et qu'on transform en JSON

    }

}