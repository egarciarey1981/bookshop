<?php

namespace Bookshop\Catalog\Infrastructure\Persistence\Pdo;

use PDO;
use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use Exception;

class PdoGenreRepository extends PdoRepository implements GenreRepository
{
    public function nextIdentity(): GenreId
    {
        return new GenreId(uniqid());
    }

    public function all(int $offset, int $limit, string $filter): array
    {
        $where = '';
        if ($filter !== '') {
            $where = 'WHERE name LIKE "%' . $filter . '%"';
        }

        $sql = <<<SQL
SELECT id, name, number_of_books
FROM genres
$where
ORDER BY name
LIMIT $limit OFFSET $offset;
SQL;

        $stmt = $this->connection->prepare($sql);
        if ($stmt->execute() === false) {
            throw new Exception('Could not fetch genres');
        }

        $rows = $stmt->fetchAll();
        if ($rows === false) {
            throw new Exception('Could not fetch genres');
        } elseif (empty($rows)) {
            return [];
        }

        return array_map(function ($row) {
            return Genre::fromPrimitives(
                $row['id'],
                $row['name'],
                $row['number_of_books'],
            );
        }, $rows);
    }

    public function count(string $filter): int
    {
        $sql = <<<SQL
SELECT COUNT(*) AS total
FROM genres
WHERE name LIKE "%$filter%"
SQL;
        $stmt = $this->connection->prepare($sql);
        if ($stmt->execute() === false) {
            throw new Exception('Could not count genres');
        }

        $row = $stmt->fetch();
        if ($row === false || is_array($row) === false) {
            throw new Exception('Could not count genres');
        }

        return (int) $row['total'];
    }

    public function ofGenreId(GenreId $genreId): ?Genre
    {
        $sql = "SELECT id, name, number_of_books FROM genres WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $genreId->value(), PDO::PARAM_STR);
        if ($stmt->execute() === false) {
            throw new Exception('Could not fetch genre');
        }

        $rows = $stmt->fetch();
        if ($rows === false || is_array($rows) === false) {
            throw new Exception('Could not fetch genre');
        } elseif (empty($rows)) {
            return null;
        }

        return Genre::fromPrimitives(
            $rows['id'],
            $rows['name'],
            $rows['number_of_books'],
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
        $stmt = $this->connection->prepare($sql);
        if ($stmt->execute($ids) === false) {
            throw new Exception('Could not fetch genres');
        }

        $rows = $stmt->fetchAll();
        if ($rows === false) {
            throw new Exception('Could not fetch genres');
        }

        return array_map(function ($row) {
            return Genre::fromPrimitives(
                $row['id'],
                $row['name'],
                $row['number_of_books'],
            );
        }, $rows);
    }

    public function insert(Genre $genre): void
    {
        $sql = "INSERT INTO genres (id, name) VALUES (:id, :name)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $genre->genreId()->value(), PDO::PARAM_STR);
        $stmt->bindValue('name', $genre->genreName()->value(), PDO::PARAM_STR);
        if ($stmt->execute() === false) {
            throw new Exception('Could not insert genre');
        }
    }

    public function update(Genre $genre): void
    {
        $sql = "UPDATE genres SET name = :name WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $genre->genreId()->value(), PDO::PARAM_STR);
        $stmt->bindValue('name', $genre->genreName()->value(), PDO::PARAM_STR);
        if ($stmt->execute() === false) {
            throw new Exception('Could not update genre');
        }
    }

    public function remove(Genre $genre): void
    {
        $sql = "DELETE FROM genres WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $genre->genreId()->value(), PDO::PARAM_STR);
        if ($stmt->execute() === false) {
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
        $stmt = $this->connection->prepare($sql);
        if ($stmt->execute() === false) {
            throw new Exception('Could not update number of books by genre');
        }
    }
}
