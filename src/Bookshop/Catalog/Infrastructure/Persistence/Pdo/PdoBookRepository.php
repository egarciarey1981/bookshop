<?php

namespace Bookshop\Catalog\Infrastructure\Persistence\Pdo;

use Bookshop\Catalog\Domain\Exception\DomainException;
use PDO;
use Bookshop\Catalog\Domain\Model\Book\Book;
use Bookshop\Catalog\Domain\Model\Book\BookCollection;
use Bookshop\Catalog\Domain\Model\Book\BookDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Book\BookId;
use Bookshop\Catalog\Domain\Model\Book\BookTitle;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;
use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Bookshop\Catalog\Domain\Model\Genre\GenreCollection;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;
use Bookshop\Catalog\Domain\Model\Genre\GenreNumberOfBooks;
use Exception;

class PdoBookRepository extends PdoRepository implements BookRepository
{
    public function nextIdentity(): BookId
    {
        return new BookId(uniqid());
    }

    public function all(int $offset, int $limit, string $filter): BookCollection
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
        $bookIds = array_map(fn ($book) => $book['id'], $books);
        $inQuery = str_repeat('?,', count($bookIds) - 1) . '?';

        $sql = <<<SQL
SELECT book_id, id, name, number_of_books
FROM books_genres
JOIN genres ON books_genres.genre_id = genres.id
WHERE book_id IN ($inQuery)
SQL;

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($bookIds);
        $genres = $stmt->fetchAll();

        $genresByBookId = [];
        foreach ($genres as $genre) {
            $genresByBookId[$genre['book_id']][] = new Genre(
                new GenreId($genre['id']),
                new GenreName($genre['name']),
                new GenreNumberOfBooks($genre['number_of_books']),
            );
        }

        return new BookCollection(...array_map(function ($book) use ($genresByBookId) {
            return new Book(
                new BookId($book['id']),
                new BookTitle($book['title']),
                new GenreCollection(...$genresByBookId[$book['id']] ?? [])
            );
        }, $books));
    }

    public function count(string $filter): int
    {
        $sql = <<<SQL
SELECT COUNT(*) AS total
FROM books
WHERE title LIKE "%$filter%"
SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        if (is_array($result) === false) {
            throw new Exception('Could not count books');
        }
        return (int) $result['total'];
    }

    public function ofBookId(BookId $bookId): Book
    {
        $sql = "SELECT id, title FROM books WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $bookId->value(), PDO::PARAM_STR);
        $stmt->execute();
        $book = $stmt->fetch();
        if (is_array($book) === false) {
            throw new BookDoesNotExistException(
                sprintf('Book with id `%s` does not exist', $bookId->value())
            );
        }

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

        return new Book(
            new BookId($book['id']),
            new BookTitle($book['title']),
            new GenreCollection(...array_map(function ($genre) {
                return new Genre(
                    new GenreId($genre['id']),
                    new GenreName($genre['name']),
                    new GenreNumberOfBooks($genre['number_of_books']),
                );
            }, $stmt->fetchAll()))
        );
    }

    public function insert(Book $book): void
    {
        $this->connection->beginTransaction();

        $sql = "INSERT INTO books (id, title) VALUES (:id, :title)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $book->bookId()->value(), PDO::PARAM_STR);
        $stmt->bindValue('title', $book->bookTitle()->value(), PDO::PARAM_STR);

        if (!$stmt->execute()) {
            $this->connection->rollBack();
            throw new DomainException('Could not insert book');
        }

        $sql = "DELETE FROM books_genres WHERE book_id = :book_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('book_id', $book->bookId()->value(), PDO::PARAM_STR);

        if (!$stmt->execute()) {
            $this->connection->rollBack();
            throw new DomainException('Could not insert book');
        }

        $sql = "INSERT INTO books_genres (book_id, genre_id) VALUES (:book_id, :genre_id)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('book_id', $book->bookId()->value(), PDO::PARAM_STR);
        foreach ($book->bookGenres() as $genre) {
            $stmt->bindValue('genre_id', $genre->genreId()->value(), PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $this->connection->rollBack();
                throw new DomainException('Could not insert book');
            }
        }

        if ($this->connection->commit() === false) {
            throw new DomainException('Could not insert book');
        }
    }

    public function update(Book $book): void
    {
        $this->connection->beginTransaction();

        $sql = "UPDATE books SET title = :title WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $book->bookId()->value(), PDO::PARAM_STR);
        $stmt->bindValue('title', $book->bookTitle()->value(), PDO::PARAM_STR);

        if (!$stmt->execute()) {
            $this->connection->rollBack();
            throw new DomainException('Could not update book');
        }

        $sql = "DELETE FROM books_genres WHERE book_id = :book_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('book_id', $book->bookId()->value(), PDO::PARAM_STR);

        if (!$stmt->execute()) {
            $this->connection->rollBack();
            throw new DomainException('Could not update book');
        }

        $sql = "INSERT INTO books_genres (book_id, genre_id) VALUES (:book_id, :genre_id)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('book_id', $book->bookId()->value(), PDO::PARAM_STR);
        foreach ($book->bookGenres() as $genre) {
            $stmt->bindValue('genre_id', $genre->genreId()->value(), PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $this->connection->rollBack();
                throw new DomainException('Could not update book');
            }
        }

        if ($this->connection->commit() === false) {
            throw new DomainException('Could not update book');
        }
    }

    public function remove(Book $book): void
    {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $book->bookId()->value(), PDO::PARAM_STR);
        $stmt->execute();

        $sql = "DELETE FROM books_genres WHERE book_id = :book_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('book_id', $book->bookId()->value(), PDO::PARAM_STR);
        if ($stmt->execute() === false) {
            throw new DomainException('Could not remove book');
        }
    }
}
