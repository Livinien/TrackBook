<?php

namespace App\Controller;

use App\Entity\Borrow;
use App\Repository\BorrowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class ApiBorrowController extends AbstractController
{
    
    #[Route('/api/borrow', name: 'app_api_book_get', methods: "GET")]
    
    public function index(BorrowRepository $borrowRepository, SerializerInterface $serializer): Response
    {

        // Factoriser la Sérialization
        // return $this->json($bookRepository->findAll(), 200, []);

        // Processus de Sérialization
        $borrow = $borrowRepository->findAll();
        
        $json = $serializer->serialize($borrow, 'json');

        $response = new JsonResponse($json, 200, [], true);

        return $response; 
        
        // Sérialization : On part d'un objet ou d'un tableau associatif PHP et qu'on transform en JSON

    }

    
    
    
    #[Route('/api/borrow', name: 'app_api_borrow_post', methods: "POST")]
    
    public function borrowPost(Request $request, SerializerInterface $serialization, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        $jsonGet = $request->getContent();

        // Condition qui inclut la déserialization et pour voir si il y a 
        try {
            
            $borrow = $serialization->deserialize($jsonGet, Borrow::class, 'json');

            $errors = $validator->validate($borrow);

            if(count($errors) > 0) {
                return $this->json($errors, 400);
            }
    
            $em->persist($borrow);
            $em->flush();
            
            return $this->json($borrow, 201, []);
            
        } catch(NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }


        // Déserialization : Récupérer le JSON et le transformer en une entitée
        // On part d'un texte du JSON pour arriver à un tableau associatif ouu d'un tableau PHP
        
    }
}