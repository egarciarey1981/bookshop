<?php

namespace Bookshop\Catalog\Infrastructure\Persistence\Pdo;

use PDO;
use Bookshop\Catalog\Domain\Model\Book\Book;
use Bookshop\Catalog\Domain\Model\Book\BookId;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;
use Bookshop\Catalog\Domain\Model\Book\BookTitle;
use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;
use Bookshop\Catalog\Domain\Model\Genre\GenreNumberOfBooks;
use Exception;

class PdoBookRepository extends PdoRepository implements BookRepository
{
    public function nextIdentity(): BookId
    {
        return BookId::create();
    }

    public function all(int $offset, int $limit, string $filter): array
    {
        $sql = 'SELECT * FROM books';

        if ($filter !== '') {
            $sql .= " WHERE title LIKE '%$filter%'";
        }

        $sql .= " ORDER BY title LIMIT $limit OFFSET $offset";

        $stmt = $this->connection()->query($sql);
        $rows = $stmt->fetchAll();

        $books = [];
        $genresByBookId = [];

        foreach ($rows as $row) {
            $books[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'genres' => [],
            ];
        }

        $sql = 'SELECT * FROM books_genres JOIN genres ON books_genres.genre_id = genres.id';
        $sql .= ' WHERE books_genres.book_id IN ("';
        $sql .= implode('", "', \array_column($books, 'id'));
        $sql .= '")';

        $stmt = $this->connection()->query($sql);
        $rows = $stmt->fetchAll();

        foreach ($rows as $row) {
            $genresByBookId[$row['book_id']][] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'number_of_books' => $row['number_of_books'],
            ];
        }

        return array_map(function ($book) use ($genresByBookId) {
            return new Book(
                new BookId($book['id']),
                new BookTitle($book['title']),
                array_map(function ($genre) {
                    return new Genre(
                        new GenreId($genre['id']),
                        new GenreName($genre['name']),
                        new GenreNumberOfBooks($genre['number_of_books']),
                    );
                }, $genresByBookId[$book['id']] ?? [])
            );
        }, $books);
    }

    public function count(string $filter): int
    {
        $sql = 'SELECT COUNT(*) AS total FROM books';

        if ($filter !== '') {
            $sql .= " WHERE title LIKE '%$filter%'";
        }

        $stmt = $this->connection()->query($sql);
        $row = $stmt->fetch();
        return (int) $row['total'];
    }

    public function ofBookId(BookId $bookId): ?Book
    {
        $id = $bookId->value();
        $sql = <<<SQL
SELECT
    books.id AS book_id,
    books.title AS book_title,
    genres.id AS genre_id,
    genres.name AS genre_name,
    genres.number_of_books AS genre_number_of_books
FROM books
    LEFT JOIN books_genres ON books.id = books_genres.book_id
    LEFT JOIN genres ON books_genres.genre_id = genres.id
WHERE books.id = '$id'
SQL;

        $stmt = $this->connection()->query($sql);
        $rows = $stmt->fetchAll();

        $data = [];

        foreach ($rows as $row) {
            $data['id'] = $row['book_id'];
            $data['title'] = $row['book_title'];
            $data['genres'][] = [
                'id' => $row['genre_id'],
                'name' => $row['genre_name'],
                'number_of_books' => $row['genre_number_of_books'],
            ];
        }

        if (empty($data)) {
            return null;
        }

        return new Book(
            new BookId($data['id']),
            new BookTitle($data['title']),
            array_map(function ($genre) {
                return new Genre(
                    new GenreId($genre['id']),
                    new GenreName($genre['name']),
                    new GenreNumberOfBooks($genre['number_of_books']),
                );
            }, $data['genres'] ?? []),
        );
    }

    public function insert(Book $book): void
    {
        $this->connection()->beginTransaction();

        $sql = "INSERT INTO books (id, title) VALUES (:id, :title)";
        $stmt = $this->connection()->prepare($sql);
        $stmt->bindValue('id', $book->bookId()->value(), PDO::PARAM_STR);
        $stmt->bindValue('title', $book->bookTitle()->value(), PDO::PARAM_STR);

        if ($stmt->execute() === false) {
            $this->connection()->rollBack();
            throw new Exception('Could not insert book');
        }

        $sql = "INSERT INTO books_genres (book_id, genre_id) VALUES (:book_id, :genre_id)";
        $stmt = $this->connection()->prepare($sql);
        $stmt->bindValue('book_id', $book->bookId()->value(), PDO::PARAM_STR);
        foreach ($book->bookGenres() as $genre) {
            $stmt->bindValue('genre_id', $genre->genreId()->value(), PDO::PARAM_STR);
            if ($stmt->execute() === false) {
                $this->connection()->rollBack();
                throw new Exception('Could not insert book');
            }
        }

        if ($this->connection()->commit() === false) {
            throw new Exception('Could not insert book');
        }
    }

    public function update(Book $book): void
    {
        $this->connection()->beginTransaction();

        $sql = "UPDATE books SET title = :title WHERE id = :id";
        $stmt = $this->connection()->prepare($sql);
        $stmt->bindValue('id', $book->bookId()->value(), PDO::PARAM_STR);
        $stmt->bindValue('title', $book->bookTitle()->value(), PDO::PARAM_STR);

        if ($stmt->execute() === false) {
            $this->connection()->rollBack();
            throw new Exception('Could not update book');
        }

        $sql = "DELETE FROM books_genres WHERE book_id = :book_id";
        $stmt = $this->connection()->prepare($sql);
        $stmt->bindValue('book_id', $book->bookId()->value(), PDO::PARAM_STR);

        if ($stmt->execute() === false) {
            $this->connection()->rollBack();
            throw new Exception('Could not update book');
        }

        $sql = "INSERT INTO books_genres (book_id, genre_id) VALUES (:book_id, :genre_id)";
        $stmt = $this->connection()->prepare($sql);
        $stmt->bindValue('book_id', $book->bookId()->value(), PDO::PARAM_STR);
        foreach ($book->bookGenres() as $genre) {
            $stmt->bindValue('genre_id', $genre->genreId()->value(), PDO::PARAM_STR);
            if ($stmt->execute() === false) {
                $this->connection()->rollBack();
                throw new Exception('Could not update book');
            }
        }

        if ($this->connection()->commit() === false) {
            throw new Exception('Could not update book');
        }
    }

    public function remove(Book $book): void
    {
        $this->connection()->beginTransaction();

        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->connection()->prepare($sql);
        $stmt->bindValue('id', $book->bookId()->value(), PDO::PARAM_STR);

        if ($stmt->execute() === false) {
            $this->connection()->rollBack();
            throw new Exception('Could not remove book');
        }

        $sql = "DELETE FROM books_genres WHERE book_id = :book_id";
        $stmt = $this->connection()->prepare($sql);
        $stmt->bindValue('book_id', $book->bookId()->value(), PDO::PARAM_STR);

        if ($stmt->execute() === false) {
            $this->connection()->rollBack();
            throw new Exception('Could not remove book');
        }

        if ($this->connection()->commit() === false) {
            throw new Exception('Could not remove book');
        }
    }
}
