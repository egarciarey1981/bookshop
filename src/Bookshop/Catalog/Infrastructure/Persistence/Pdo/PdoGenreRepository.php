<?php

namespace Bookshop\Catalog\Infrastructure\Persistence\Pdo;

use PDO;
use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;
use Bookshop\Catalog\Domain\Model\Genre\GenreNumberOfBooks;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use Exception;

class PdoGenreRepository extends PdoRepository implements GenreRepository
{
    public function nextIdentity(): GenreId
    {
        return GenreId::create();
    }

    public function all(int $offset, int $limit, string $filter): array
    {
        $sql = 'SELECT * FROM genres';

        if ($filter !== '') {
            $sql .= " WHERE name LIKE '%$filter%'";
        }

        $sql .= " ORDER BY name LIMIT $limit OFFSET $offset";

        $stmt = $this->connection()->query($sql);
        $rows = $stmt->fetchAll();

        return array_map(function ($row) {
            return new Genre(
                new GenreId($row['id']),
                new GenreName($row['name']),
                new GenreNumberOfBooks($row['number_of_books']),
            );
        }, $rows);
    }

    public function count(string $filter): int
    {
        $sql = 'SELECT COUNT(*) AS total FROM genres';

        if ($filter !== '') {
            $sql .= " WHERE name LIKE '%$filter%'";
        }

        $stmt = $this->connection()->query($sql);
        $row = $stmt->fetch();
        return (int) $row['total'];
    }

    public function ofGenreId(GenreId $genreId): ?Genre
    {
        $id = $genreId->value();
        $sql = "SELECT * FROM genres WHERE id = '$id'";
        $stmt = $this->connection()->query($sql);
        $row = $stmt->fetch();

        return new Genre(
            new GenreId($row['id']),
            new GenreName($row['name']),
            new GenreNumberOfBooks($row['number_of_books']),
        );
    }

    public function ofGenreIds(array $genreIds): array
    {
        if (count($genreIds) === 0) {
            return [];
        }

        $inQuery = str_repeat('?,', count($genreIds) - 1) . '?';
        $ids = array_map(fn ($genreId) => $genreId->value(), $genreIds);
        $sql = "SELECT id, name, number_of_books FROM genres WHERE id IN ($inQuery)";
        $stmt = $this->connection()->prepare($sql);
        if ($stmt->execute($ids) === false) {
            throw new Exception('Could not fetch genres');
        }

        $rows = $stmt->fetchAll();
        if ($rows === false) {
            throw new Exception('Could not fetch genres');
        }

        return array_map(function ($row) {
            return new Genre(
                new GenreId($row['id']),
                new GenreName($row['name']),
                new GenreNumberOfBooks($row['number_of_books']),
            );
        }, $rows);
    }

    public function insert(Genre $genre): void
    {
        $sql = "INSERT INTO genres (id, name, number_of_books) VALUES (:id, :name, :number_of_books)";
        $stmt = $this->connection()->prepare($sql);
        $stmt->bindValue('id', $genre->genreId()->value(), PDO::PARAM_STR);
        $stmt->bindValue('name', $genre->genreName()->value(), PDO::PARAM_STR);
        $stmt->bindValue('number_of_books', $genre->genreNumberOfBooks()->value(), PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            throw new Exception('Could not insert genre');
        }
    }

    public function update(Genre $genre): void
    {
        $sql = "UPDATE genres SET name = :name WHERE id = :id";
        $stmt = $this->connection()->prepare($sql);
        $stmt->bindValue('id', $genre->genreId()->value(), PDO::PARAM_STR);
        $stmt->bindValue('name', $genre->genreName()->value(), PDO::PARAM_STR);
        if ($stmt->execute() === false) {
            throw new Exception('Could not update genre');
        }
    }

    public function remove(Genre $genre): void
    {
        $this->connection()->beginTransaction();

        $sql = "DELETE FROM genres WHERE id = :id";
        $stmt = $this->connection()->prepare($sql);
        $stmt->bindValue('id', $genre->genreId()->value(), PDO::PARAM_STR);
        if ($stmt->execute() === false) {
            throw new Exception('Could not remove genre');
        }

        $sql = "DELETE FROM books_genres WHERE genre_id = :genre_id";
        $stmt = $this->connection()->prepare($sql);
        $stmt->bindValue('genre_id', $genre->genreId()->value(), PDO::PARAM_STR);
        if ($stmt->execute() === false) {
            throw new Exception('Could not remove genre');
        }

        if ($this->connection()->commit() === false) {
            throw new Exception('Could not remove genre');
        }
    }

    public function updateNumberOfBooksByGenreService(): void
    {
        $sql = <<<SQL
UPDATE genres
SET number_of_books = (
    SELECT COUNT(*)
    FROM books_genres
    WHERE books_genres.genre_id = genres.id
)
SQL;
        $stmt = $this->connection()->prepare($sql);
        if ($stmt->execute() === false) {
            throw new Exception('Could not update number of books by genre');
        }
    }
}
