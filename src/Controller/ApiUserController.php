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
use Symfony\Component\Serializer\Exception\NotEncodableValueException;



class ApiUserController extends AbstractController
{

    // RÉCUPÉRER TOUS LES UTILISATEURS DE L'APPLICATION
    
    // OK
    #[Route('/api/v1/users', name: 'app_api_users', methods: ["GET"])]
    public function users(UserRepository $userRepository, Request $request, SerializerInterface $serialization): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        $json = $serialization->serialize($users, "json", ['groups' => 'post:read']);
    
        $response = new Response($json, 200, ["Content-Type" => "application/json"]);
        return $response;
    }
    


    
    // S'IDENTIFIER EN TANT QU'UTILISATEUR SUR L'APPLICATION / SE LOGUER
    
    // OK
    #[Route('/api/v1/user/login', name: 'app_api_user', methods: ["GET"])]
    public function login(UserRepository $userRepository, Request $request, SerializerInterface $serialization): Response
    {
        
        // DEUXIÈME METHODE AVEC SymfonyRequest-bundle
        $uuid = $request->get("uuid");
        try {
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(["uuid" => $uuid]);
    
                if(!$user){
                    return $this->json(["error" => "Utilisateur Inexistant"], 200);
                }
    
            $json = $serialization->serialize($user, "json", ['groups' => 'post:read']);
    
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