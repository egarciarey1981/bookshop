<?php

namespace Bookshop\Catalog\Infrastructure\Persistence\Pdo;

use PDO;
use Bookshop\Catalog\Domain\Model\Book\Book;
use Bookshop\Catalog\Domain\Model\Book\BookId;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;
use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Exception;

class PdoBookRepository extends PdoRepository implements BookRepository
{
    public function nextIdentity(): BookId
    {
        return new BookId(uniqid());
    }

    public function all(int $offset, int $limit, string $filter): array
    {
        $where = empty($filter) ? '' : "WHERE title LIKE '%$filter%'";

        $sql = <<<SQL
SELECT id, title
FROM books
$where
ORDER BY title
LIMIT $limit OFFSET $offset;
SQL;

        $stmt = $this->connection->prepare($sql);
        if ($stmt->execute() === false) {
            throw new Exception('Could not fetch books');
        }

        $rows = $stmt->fetchAll();
        if ($rows === false) {
            throw new Exception('Could not fetch books');
        } elseif (empty($rows)) {
            return [];
        }

        $books = array_map(function ($row) {
            return Book::fromPrimitives(
                $row['id'],
                $row['title'],
            );
        }, $rows);

        $bookIds = array_column($rows, 'id');
        $inQuery = str_repeat('?,', count($bookIds) - 1) . '?';

        $sql = <<<SQL
SELECT book_id, id, name, number_of_books
FROM books_genres
JOIN genres ON books_genres.genre_id = genres.id
WHERE book_id IN ($inQuery)
SQL;

        $stmt = $this->connection->prepare($sql);
        if ($stmt->execute($bookIds) === false) {
            throw new Exception('Could not fetch genres');
        }

        $rows = $stmt->fetchAll();
        $genresByBookId = [];
        foreach ($rows as $row) {
            $genresByBookId[$row['book_id']][] = Genre::fromPrimitives(
                $row['id'],
                $row['name'],
                $row['number_of_books'],
            );
        }

        return array_map(function ($book) use ($genresByBookId) {
            return $book->setGenres($genresByBookId[$book->bookId()->value()]);
        }, $books);
    }

    public function count(string $filter): int
    {
        $sql = <<<SQL
SELECT COUNT(*) AS total
FROM books
WHERE title LIKE "%$filter%"
SQL;
        $stmt = $this->connection->prepare($sql);
        if ($stmt->execute() === false) {
            throw new Exception('Could not count books');
        }

        $row = $stmt->fetch();
        if ($row === false || is_array($row) === false) {
            throw new Exception('Could not count books');
        }

        return (int) $row['total'];
    }

    public function ofBookId(BookId $bookId): ?Book
    {
        $sql = "SELECT id, title FROM books WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $bookId->value(), PDO::PARAM_STR);
        if ($stmt->execute() === false) {
            throw new Exception('Could not fetch book');
        }

        $row = $stmt->fetch();
        if ($row === false || is_array($row) === false) {
            return null;
        }

        $book = Book::fromPrimitives(
            $row['id'],
            $row['title'],
        );

        $sql = <<<SQL
SELECT id, name, number_of_books
FROM books_genres
JOIN genres ON books_genres.genre_id = genres.id
WHERE book_id = :book_id
SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('book_id', $bookId->value(), PDO::PARAM_STR);
        if ($stmt->execute() === false) {
            throw new Exception('Could not count books');
        }

        $rows = $stmt->fetchAll();

        if ($rows === false) {
            throw new Exception('Could not fetch genres');
        } elseif (empty($rows)) {
            return $book;
        }

        $genres = array_map(function ($row) {
            return Genre::fromPrimitives(
                $row['id'],
                $row['name'],
                $row['number_of_books'],
            );
        }, $rows);

        return $book->setGenres($genres);
    }

    public function insert(Book $book): void
    {
        $this->connection->beginTransaction();

        $sql = "INSERT INTO books (id, title) VALUES (:id, :title)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $book->bookId()->value(), PDO::PARAM_STR);
        $stmt->bindValue('title', $book->bookTitle()->value(), PDO::PARAM_STR);

        if ($stmt->execute() === false) {
            $this->connection->rollBack();
            throw new Exception('Could not insert book');
        }

        $sql = "INSERT INTO books_genres (book_id, genre_id) VALUES (:book_id, :genre_id)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('book_id', $book->bookId()->value(), PDO::PARAM_STR);
        foreach ($book->bookGenres() as $genre) {
            $stmt->bindValue('genre_id', $genre->genreId()->value(), PDO::PARAM_STR);
            if ($stmt->execute() === false) {
                $this->connection->rollBack();
                throw new Exception('Could not insert book');
            }
        }

        if ($this->connection->commit() === false) {
            throw new Exception('Could not insert book');
        }
    }

    public function update(Book $book): void
    {
        $this->connection->beginTransaction();

        $sql = "UPDATE books SET title = :title WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $book->bookId()->value(), PDO::PARAM_STR);
        $stmt->bindValue('title', $book->bookTitle()->value(), PDO::PARAM_STR);

        if ($stmt->execute() === false) {
            $this->connection->rollBack();
            throw new Exception('Could not update book');
        }

        $sql = "DELETE FROM books_genres WHERE book_id = :book_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('book_id', $book->bookId()->value(), PDO::PARAM_STR);

        if ($stmt->execute() === false) {
            $this->connection->rollBack();
            throw new Exception('Could not update book');
        }

        $sql = "INSERT INTO books_genres (book_id, genre_id) VALUES (:book_id, :genre_id)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('book_id', $book->bookId()->value(), PDO::PARAM_STR);
        foreach ($book->bookGenres() as $genre) {
            $stmt->bindValue('genre_id', $genre->genreId()->value(), PDO::PARAM_STR);
            if ($stmt->execute() === false) {
                $this->connection->rollBack();
                throw new Exception('Could not update book');
            }
        }

        if ($this->connection->commit() === false) {
            throw new Exception('Could not update book');
        }
    }

    public function remove(Book $book): void
    {
        $this->connection->beginTransaction();

        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $book->bookId()->value(), PDO::PARAM_STR);

        if ($stmt->execute() === false) {
            $this->connection->rollBack();
            throw new Exception('Could not remove book');
        }

        $sql = "DELETE FROM books_genres WHERE book_id = :book_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('book_id', $book->bookId()->value(), PDO::PARAM_STR);

        if ($stmt->execute() === false) {
            $this->connection->rollBack();
            throw new Exception('Could not remove book');
        }

        if ($this->connection->commit() === false) {
            throw new Exception('Could not remove book');
        }
    }
}
