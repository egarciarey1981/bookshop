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
    public function all(int $offset, int $limit, string $filter): array
    {
        $sql = <<<SQL
SELECT id, title
FROM books
WHERE title LIKE "%$filter%"
ORDER BY title
LIMIT $limit OFFSET $offset;
SQL;

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $books = $stmt->fetchAll();
        return array_map(function ($book) {
            return new Book(
                new BookId($book['id']),
                new BookTitle($book['title'])
            );
        }, $books);
    }

    public function count(string $filter): int
    {
        $sql = <<<SQL
SELECT COUNT(*)
FROM books
WHERE title LIKE "%$filter%"
SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function ofBookId(BookId $id): Book
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

    public function save(Book $book): void
    {
        $sql = "INSERT INTO books (id, title) VALUES (:id, :title) ON DUPLICATE KEY UPDATE title = :title";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $book->id()->value(), PDO::PARAM_STR);
        $stmt->bindValue('title', $book->title()->value(), PDO::PARAM_STR);
        $stmt->execute();
    }

    public function remove(Book $book): void
    {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $book->id()->value(), PDO::PARAM_STR);
        $stmt->execute();

        if (!$stmt->rowCount()) {
            throw new BookDoesNotExistException($book->id());
        }
    }

    public function nextIdentity(): BookId
    {
        return new BookId(uniqid());
    }
}
