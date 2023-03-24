<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiUserController extends AbstractController
{
    #[Route('/api/v1/user/login', name: 'app_api_user', methods: ["POST"])]
    public function index(UserRepository $userRepository, Request $request, SerializerInterface $serialization): Response
    {
        // PREMIÈRE METHODE AVEC SymfonyRequest-bundle
        $userId = json_decode($request->getContent(), true);
        $uuid = $userId["uuid"];
        
        // DEUXIÈME METHODE AVEC SymfonyRequest-bundle
        $uuid = $request->get("uuid");
        try {
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(["uuid" => $uuid]);
    
                if(!$user){
                    return $this->json(["error" => "Utilisateur Inexistant"], 200);
                }
    
            $json = $serialization->serialize($user, "json");
    
            $response = new Response($json, 200, ["Content-Type" => "application/json"]);
            return $response;
            
        } catch(NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}