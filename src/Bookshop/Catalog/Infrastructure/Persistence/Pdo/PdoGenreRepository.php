<?php

namespace Bookshop\Catalog\Infrastructure\Persistence\Pdo;

use PDO;
use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use Exception;

class PdoGenreRepository extends PdoRepository implements GenreRepository
{
    public function all(int $offset, int $limit, string $filter): array
    {
        $sql = <<<SQL
SELECT id, name, number_of_books
FROM genres
WHERE name LIKE "%$filter%"
ORDER BY name
LIMIT $limit OFFSET $offset;
SQL;

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $genres = $stmt->fetchAll();
        return array_map(function ($genre) {
            return new Genre(
                new GenreId($genre['id']),
                new GenreName($genre['name']),
                $genre['number_of_books'],
            );
        }, $genres);
    }

    public function count(string $filter): int
    {
        $sql = <<<SQL
SELECT COUNT(*) AS total
FROM genres
WHERE name LIKE "%$filter%"
SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        if (is_array($result) === false) {
            throw new Exception('Could not count genres');
        }
        return (int) $result['total'];
    }

    public function ofGenreId(GenreId $genreId): ?Genre
    {
        $sql = "SELECT id, name, number_of_books FROM genres WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $genreId->value(), PDO::PARAM_STR);
        $stmt->execute();
        $genre = $stmt->fetch();
        if (!$genre) {
            return null;
        }
        if (is_array($genre) === false) {
            throw new Exception('Could not count genres');
        }
        return new Genre(
            new GenreId($genre['id']),
            new GenreName($genre['name']),
            $genre['number_of_books'],
        );
    }

    public function ofGenreIds(array $genreIds): array
    {
        if (count($genreIds) === 0) {
            return [];
        }

        $inQuery = str_repeat('?,', count($genreIds) - 1) . '?';
        $sql = "SELECT id, name, number_of_books FROM genres WHERE id IN ($inQuery)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(
            array_map(
                fn ($genreId) => $genreId->value(),
                $genreIds
            )
        );
        $genres = $stmt->fetchAll();
        return array_map(function ($genre) {
            return new Genre(
                new GenreId($genre['id']),
                new GenreName($genre['name']),
                $genre['number_of_books'],
            );
        }, $genres);
    }

    public function insert(Genre $genre): bool
    {
        $sql = "INSERT INTO genres (id, name) VALUES (:id, :name)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $genre->genreId()->value(), PDO::PARAM_STR);
        $stmt->bindValue('name', $genre->genreName()->value(), PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update(Genre $genre): bool
    {
        $sql = "UPDATE genres SET name = :name WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $genre->genreId()->value(), PDO::PARAM_STR);
        $stmt->bindValue('name', $genre->genreName()->value(), PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function remove(Genre $genre): bool
    {
        $sql = "DELETE FROM genres WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $genre->genreId()->value(), PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function nextIdentity(): GenreId
    {
        return new GenreId(uniqid());
    }

    public function updateNumberOfBooksByGenreService(): bool
    {
        $sql = <<<SQL
UPDATE genres
SET number_of_books = (
    SELECT COUNT(*)
    FROM books_genres
    WHERE books_genres.genre_id = genres.id
)
SQL;
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute();
    }
}
