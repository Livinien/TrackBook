<?php

namespace App\Controller;

use DateTime;
use App\Entity\Book;
use App\Entity\Borrow;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
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



// Sérialization : On part d'un objet ou d'un tableau associatif PHP et qu'on transforme en JSON

// Déserialization : Récupérer le JSON et le transformer en une entitée
// On part d'un texte du JSON pour arriver à un tableau associatif ouu d'un tableau PHP



class ApiBookController extends AbstractController
{

    // REQUÊTE GET POUR RÉCUPÉRER TOUS LES LIVRES DE LA BOX
    
    // OK
    #[Route('/api/v1/books/get', name: 'app_api_book_get', methods: "GET")]
    public function bookGet(BookRepository $bookRepository, SerializerInterface $serializer): Response
    {
        // Factoriser la Sérialization
        // return $this->json($bookRepository->findAll(), 200, []);

        // Processus de Sérialization
        $books = $bookRepository->findAll();

        $json = $serializer->serialize($books, 'json', ['groups' => 'post:read']);

        $response = new JsonResponse($json, 200, [], true);

        return $response;
    }

    

    
    // REQUÊTE POST POUR EMPRUNTER UN LIVRE
    
    // OK
    #[Route('/api/v1/book', name: 'book_borrow_post', methods: ["POST"])]
    public function borrowBook( SerializerInterface $serializer, Request $request, BookRepository $bookRepository, UserRepository $userRepository, EntityManagerInterface $em): Response
    { 
        $bookId = $request->get("idBook");
        $book   = $bookRepository->find($bookId);
        $userId = $request->get("id");
        $user   = $userRepository->find($userId);

        $borrow = new Borrow();
        $borrow->addBook($book);
        $borrow->setIdUser($user);
        $borrow->setDateBorrow(new DateTime());
        $book->setIsAvailable(false);

        $em->persist($borrow);
        $em->flush();
        return $this->json(["Message" => "Book borrowed !"]);
    }
    

    
    // RÉCUPÉRER LES INFORMATIONS DU LIVRE
    
    #[Route('/api/v1/bookInfo', name: 'app_api_bookInfo', methods: ["GET"])]
    public function bookGetOne(BookRepository $bookRepository, Request $request, SerializerInterface $serialization): Response
    {
        
        $id = $request->get("id");
        try {
            $book = $this->getDoctrine()
                ->getRepository(Book::class)
                ->findOneBy(["id" => $id]);
    
                if(!$book){
                    return $this->json(["error" => "Le book n'a pas été trouvé"], 200);
                }
    
            $json = $serialization->serialize($book, "json", ['groups' => 'post:read']);
    
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

    
    
    // RETOUR D'UN LIVRE DANS UNE BOITE À LIVRE
    
    // OK
    #[Route('/api/v1/bookReturn/{id_book}', name: 'app_api_book_return', methods: "PATCH")]
    public function bookReturn(BookRepository $bookRepository, BorrowRepository $borrowRepository, $id_book, Request $request, SerializerInterface $serialization, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        $book     = $bookRepository->find($id_book);
        $borrowId = $book->getIdBorrow();
        $borrow   = $borrowRepository->find(['id' => $borrowId]);

        $borrow->setDateReturn(new DateTime());
        $book->setIsAvailable(true);
        
        $em->persist($borrow);
        $em->flush();
        
        return $this->json(["Message" => "Book Returned !"]);

    }
}