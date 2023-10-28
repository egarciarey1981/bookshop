<?php

namespace Bookshop\Catalog\Infrastructure\Persistence\Pdo;

use PDO;
use Bookshop\Catalog\Domain\Book\Book;
use Bookshop\Catalog\Domain\Book\BookId;
use Bookshop\Catalog\Domain\Book\BookTitle;
use Bookshop\Catalog\Domain\Book\BookRepository;
use Bookshop\Catalog\Domain\Book\BookDoesNotExistException;

class PdoBookRepository extends PdoRepository implements BookRepository
{
    public function all(int $offset, int $limit): array
    {
        $sql = 'SELECT * FROM books LIMIT :limit OFFSET :offset';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $books = $stmt->fetchAll();
        return array_map(function ($book) {
            return new Book(
                new BookId($book['id']),
                new BookTitle($book['title'])
            );
        }, $books);
    }

    public function ofId(BookId $id): Book
    {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $id->value(), PDO::PARAM_STR);
        $stmt->execute();
        $book = $stmt->fetch();
        if (!$book) {
            throw new BookDoesNotExistException($id);
        }
        return new Book(
            new BookId($book['id']),
            new BookTitle($book['title'])
        );
    }

    public function insert(Book $book): void
    {
        $sql = "INSERT INTO books (id, title) VALUES (:id, :title)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $book->id()->value(), PDO::PARAM_STR);
        $stmt->bindValue('title', $book->title()->value(), PDO::PARAM_STR);
        $stmt->execute();
    }

    public function update(Book $book): void
    {
        $sql = "UPDATE books SET title = :title WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $book->id()->value(), PDO::PARAM_STR);
        $stmt->bindValue('title', $book->title()->value(), PDO::PARAM_STR);
        $stmt->execute();

        if (!$stmt->rowCount()) {
            throw new BookDoesNotExistException($book->id());
        }
    }

    public function delete(BookId $bookId): void
    {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $bookId->value(), PDO::PARAM_STR);
        $stmt->execute();

        if (!$stmt->rowCount()) {
            throw new BookDoesNotExistException($bookId);
        }
    }

    public function nextIdentity(): BookId
    {
        return new BookId(uniqid());
    }
}
