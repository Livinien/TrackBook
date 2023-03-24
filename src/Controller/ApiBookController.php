<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class ApiBookController extends AbstractController
{

    // REQUÊTE GET DES LIVRES POUR RÉCUPÉRER LES LIVRES
    
    #[Route('/api/book', name: 'app_api_book_get', methods: "GET")]
    
    public function bookGet(BookRepository $bookRepository, SerializerInterface $serializer): Response
    {

        // Factoriser la Sérialization
        // return $this->json($bookRepository->findAll(), 200, []);

        // Processus de Sérialization
        $books = $bookRepository->findAll();
        
        $json = $serializer->serialize($books, 'json');

        $response = new JsonResponse($json, 200, [], true);

        return $response; 
        
        // Sérialization : On part d'un objet ou d'un tableau associatif PHP et qu'on transform en JSON

    }


    
    // REQUÊTE POST DES LIVRES POUR POSTER DES LIVRES
    
    #[Route('/api/v1/book', name: 'app_api_book_post', methods: "POST")]
    public function bookPost(Request $request, SerializerInterface $serialization, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        $jsonGet = $request->getContent();

        // Condition qui inclut la déserialization et pour voir si il y a 
        try {
            
            $books = $serialization->deserialize($jsonGet, Book::class, 'json');

            $errors = $validator->validate($books);

            if(count($errors) > 0) {
                return $this->json($errors, 400);
            }
    
            $em->persist($books);
            $em->flush();
            
            return $this->json($books, 201, []);
            
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