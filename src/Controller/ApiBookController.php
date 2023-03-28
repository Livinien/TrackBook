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

// Sérialization : 

// Déserialization : Récupérer le JSON et le transformer en une entitée
// On part d'un texte du JSON pour arriver à un tableau associatif ouu d'un tableau PHP


class ApiBookController extends AbstractController
{

    // REQUÊTE GET DES LIVRES POUR RÉCUPÉRER TOUS LES LIVRES DE LA BOX
    
    #[Route('/api/v1/book/get', name: 'app_api_book_get', methods: "GET")]
    public function bookGet(BookRepository $bookRepository, SerializerInterface $serializer): Response
    {
        // Factoriser la Sérialization
        // return $this->json($bookRepository->findAll(), 200, []);

        // Processus de Sérialization
        $books = $bookRepository->findAll();

        $json = $serializer->serialize($books, 'json', ['groups' => 'post:read']);

        $response = new JsonResponse($json, 200, [], true);

        return $response;
        
        // Sérialization : On part d'un objet ou d'un tableau associatif PHP et qu'on transforme en JSON
    }

    

    
    // EMPREINTER UN LIVRE GRÂCE À SON ID
    
    #[Route('/api/v1/books/{id_book}', name: 'post_books_borrow', methods: ["POST"])]
    public function borrowBook($id_book, SerializerInterface $serializer, Request $request, BookRepository $bookRepository, UserRepository $userRepository, EntityManagerInterface $em): Response
    {
        $book   = $bookRepository->find($id_book);
        $userId = $request->get("id");
        $user   = $userRepository->find($userId);

        $borrow = new BorrowBook();
        $borrow->setBook($book);
        $borrow->setUser($user);
        $borrow->setBorrowDate(new DateTime());
        $book->setIsAvailable(false);

        $em->persist($borrow);
        $em->flush();
        return $this->json(["Message" => "Book borrowed!"]);
    }
    

    
    // RETOUR DE L'ID D'UN LIVRE
    
    #[Route('/api/v1/bookReturn/{id_book}', name: 'app_api_book_return', methods: "POST")]
    public function bookReturn($id ,Request $request, SerializerInterface $serialization, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        $bookReturn = $bookRepository->findAll();

    }
}