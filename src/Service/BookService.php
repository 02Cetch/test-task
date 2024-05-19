<?php

namespace App\Service;

use App\Mapper\BookMapper;
use App\Repository\BookRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

class BookService
{
    private Connection $connection;

    public function __construct(
        public readonly BookRepository $repository,
        private readonly EntityManagerInterface $entityManager
    ) {
        $this->connection = $this->entityManager->getConnection();
    }

    public function add(BookMapper $book): void
    {
        $statement = $this->connection->prepare('CALL AddBook(:title, :author, :publicationYear)');
        $statement->executeStatement([
            'title' => $book->title,
            'author' => $book->author,
            'publicationYear' => $book->publicationYear
        ]);
    }

    public function update(int $id, BookMapper $book): void
    {
        $statement = $this->connection->prepare('CALL UpdateBook(:id, :title, :author, :publicationYear)');
        $statement->executeStatement([
            'id' => $id,
            'title' => $book->title,
            'author' => $book->author,
            'publicationYear' => $book->publicationYear
        ]);
    }

    public function delete($id): void
    {
        $statement = $this->connection->prepare('CALL DeleteBook(:id)');
        $statement->executeStatement([
            'id' => $id,
        ]);
    }
}
