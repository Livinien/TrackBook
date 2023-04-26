<?php

namespace App\Controller;

use App\Entity\Box;
use App\Repository\BoxRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class ApiBoxController extends AbstractController
{

    // REQUÊTE GET POUR RÉCUPÉRER TOUTES LES BOX
    
    // OK
    #[Route('/api/v1/box/get', name: 'app_api_box_get', methods: "GET")]
    
    public function boxGet(BoxRepository $boxRepository, SerializerInterface $serializer): Response
    {

        // Factoriser la Sérialization
        // return $this->json($bookRepository->findAll(), 200, []);

        // Processus de Sérialization
        $box = $boxRepository->findAll();
        
        $json = $serializer->serialize($box, 'json', ['groups' => 'post:read']);


        $response = new JsonResponse($json, 200, [], true);

        return $response; 
        
        // Sérialization : On part d'un objet ou d'un tableau associatif PHP et qu'on transform en JSON

    }

    
    #[Route('/api/v1/box/{id}', name: 'app_api_box', methods: ["GET"])]
    public function boxGetOne(BoxRepository $boxRepository, $id, Request $request, SerializerInterface $serialization): Response
    {
        
        // DEUXIÈME METHODE AVEC SymfonyRequest-bundle
        try {
            $box = $this->getDoctrine()
                ->getRepository(Box::class)
                ->findOneBy(["id" => $id]);
    
                if(!$box){
                    return $this->json(["error" => "La box n'a pas été trouvé"], 200);
                }
    
            $json = $serialization->serialize($box, "json", ['groups' => 'post:read']);
    
            $response = new Response($json, 200, ["Content-Type" => "application/json"]);
            return $response;
            
            // En cas d'erreur si la condition ne fonctionne pas
        } catch(NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}