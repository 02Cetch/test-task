<?php

namespace App\Controller;

use App\Mapper\BookMapper;
use App\Service\BookService;
use App\Service\ValidationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/', name: 'book')]
class BookController extends AbstractController
{
    public function __construct(
        private readonly BookService            $bookService,
        private readonly SerializerInterface    $serializer,
        private readonly ValidationService      $validationService
    )
    {
    }

    #[Route("/books", name: "_list", methods: ["GET"])]
    public function getBooks(): JsonResponse
    {
        $books = $this->bookService->repository->findAll();

        $data = $this->serializer->serialize($books, 'json');
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route("/book", name: "_create", methods: ["POST"])]
    public function addBook(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $book = BookMapper::from($data);
        $errors = $this->validationService->validate($book);
        if (count($errors) > 0) {
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST);
        }

        $this->bookService->add($book);
        return new JsonResponse('Book created!', Response::HTTP_CREATED);
    }

    #[Route("/book/{id}", name: "_update", methods: ["PUT"])]
    public function updateBook($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $book = $this->bookService->repository->find($id);
        if (!$book) {
            return new JsonResponse('Book not found', Response::HTTP_NOT_FOUND);
        }

        $bookPayload = BookMapper::from($data);
        $errors = $this->validationService->validate($book);
        if (count($errors) > 0) {
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST);
        }

        $this->bookService->update($id, $bookPayload);
        return new JsonResponse('Book updated!', Response::HTTP_OK);
    }

    #[Route("/book/{id}", name: "_delete", methods: ["DELETE"])]
    public function deleteBook(int $id): JsonResponse
    {
        $book = $this->bookService->repository->find($id);
        if (!$book) {
            return new JsonResponse('Book not found', Response::HTTP_NOT_FOUND);
        }

        $this->bookService->delete($id);
        return new JsonResponse('Book deleted!', Response::HTTP_NO_CONTENT);
    }
}
