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

    // REQUÊTE GET POUR L'EMPRUNT DES LIVRES
    
    // OK
    #[Route('/api/v1/borrow/get', name: 'app_api_borrow_get', methods: "GET")]
    
    public function borrowGet(BorrowRepository $borrowRepository, SerializerInterface $serializer): Response
    {
        
        // Factoriser la Sérialization
        // return $this->json($bookRepository->findAll(), 200, []);

        // Processus de Sérialization
        $borrow = $borrowRepository->findAll();
        
        $json = $serializer->serialize($borrow, 'json');

        $response = new JsonResponse($json, 200, [], true);

        return $response; 
    }

    
    
    
    // REQUÊTE POST POUR L'EMPRUNT DES LIVRES
    
    // OK
    #[Route('/api/v1/borrow/post', name: 'app_api_borrow_post', methods: "POST")]
    
    public function borrowPost(Request $request, SerializerInterface $serialization, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        
        $jsonGet = $request->getContent();

        // Condition qui inclut la déserialization et pour voir si il y a la présence d'information contenant minmum 3 caractères.
        try {
            
            $borrow = $serialization->deserialize($jsonGet, Borrow::class, 'json', ['groups' => 'post:read']);

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
    }
}