<?php

namespace Bookshop\Catalog\Infrastructure\Persistence\Pdo;

use PDO;
use Bookshop\Catalog\Domain\Model\Book\Book;
use Bookshop\Catalog\Domain\Model\Book\BookId;
use Bookshop\Catalog\Domain\Model\Book\BookTitle;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;
use Bookshop\Catalog\Domain\Model\Book\BookDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;
use Bookshop\Catalog\Domain\Model\Genre\GenresCollection;

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
        $bookIds = array_map(fn ($book) => $book['id'], $books);
        $inQuery = str_repeat('?,', count($bookIds) - 1) . '?';

        $sql = <<<SQL
SELECT book_id, id, name
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
                new GenreName($genre['name'])
            );
        }

        return array_map(function ($book) use ($genresByBookId) {
            return new Book(
                new BookId($book['id']),
                new BookTitle($book['title']),
                new GenresCollection(...$genresByBookId[$book['id']] ?? [])
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

    public function ofBookId(BookId $bookId): Book
    {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $bookId->value(), PDO::PARAM_STR);
        $stmt->execute();
        $book = $stmt->fetch();
        if (!$book) {
            throw new BookDoesNotExistException($bookId);
        }

        $sql = <<<SQL
SELECT id, name
FROM books_genres
JOIN genres ON books_genres.genre_id = genres.id
WHERE book_id = :book_id
SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('book_id', $bookId->value(), PDO::PARAM_STR);
        $stmt->execute();
        $genres = $stmt->fetchAll();

        array_walk($genres, function (&$genre) {
            $genre = new Genre(
                new GenreId($genre['id']),
                new GenreName($genre['name'])
            );
        });

        return new Book(
            new BookId($book['id']),
            new BookTitle($book['title']),
            new GenresCollection(...$genres)
        );
    }

    public function save(Book $book): void
    {
        $sql = "INSERT INTO books (id, title) VALUES (:id, :title) ON DUPLICATE KEY UPDATE title = :title";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $book->bookId()->value(), PDO::PARAM_STR);
        $stmt->bindValue('title', $book->bookTitle()->value(), PDO::PARAM_STR);
        $stmt->execute();

        $sql = "DELETE FROM books_genres WHERE book_id = :book_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('book_id', $book->bookId()->value(), PDO::PARAM_STR);
        $stmt->execute();

        $sql = "INSERT INTO books_genres (book_id, genre_id) VALUES (:book_id, :genre_id)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('book_id', $book->bookId()->value(), PDO::PARAM_STR);
        foreach ($book->bookGenres() as $genre) {
            $stmt->bindValue('genre_id', $genre->genreId()->value(), PDO::PARAM_STR);
            $stmt->execute();
        }
    }

    public function remove(Book $book): void
    {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $book->bookId()->value(), PDO::PARAM_STR);
        $stmt->execute();

        if (!$stmt->rowCount()) {
            throw new BookDoesNotExistException($book->bookId());
        }

        $sql = "DELETE FROM books_genres WHERE book_id = :book_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('book_id', $book->bookId()->value(), PDO::PARAM_STR);
        $stmt->execute();
    }

    public function nextIdentity(): BookId
    {
        return new BookId(uniqid());
    }
}