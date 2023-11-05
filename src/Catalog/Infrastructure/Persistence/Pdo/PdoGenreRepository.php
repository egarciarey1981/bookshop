<?php

namespace Bookshop\Catalog\Infrastructure\Persistence\Pdo;

use PDO;
use Bookshop\Catalog\Domain\Genre\Genre;
use Bookshop\Catalog\Domain\Genre\GenreId;
use Bookshop\Catalog\Domain\Genre\GenreName;
use Bookshop\Catalog\Domain\Genre\GenreRepository;
use Bookshop\Catalog\Domain\Genre\GenreDoesNotExistException;

class PdoGenreRepository extends PdoRepository implements GenreRepository
{
    public function all(int $offset, int $limit, string $filter): array
    {
        $sql = <<<SQL
SELECT id, name
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
                new GenreName($genre['name'])
            );
        }, $genres);
    }

    public function count(string $filter): int
    {
        $sql = <<<SQL
SELECT COUNT(*)
FROM genres
WHERE name LIKE "%$filter%"
SQL;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function ofGenreId(GenreId $id): Genre
    {
        $sql = "SELECT * FROM genres WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $id->value(), PDO::PARAM_STR);
        $stmt->execute();
        $genre = $stmt->fetch();
        if (!$genre) {
            throw new GenreDoesNotExistException($id);
        }
        return new Genre(
            new GenreId($genre['id']),
            new GenreName($genre['name'])
        );
    }

    public function ofGenreIds(array $genreIds): array
    {
        $sql = "SELECT * FROM genres WHERE id IN (:genre_ids)";
        
        $stmt = $this->connection->prepare($sql);
        $foo = implode("','", array_map(
            function ($genreId) {
                return $genreId->value();
            },
            $genreIds
        ));
        $stmt->bindValue('genre_ids', $foo, PDO::PARAM_STR_CHAR);
        $stmt->execute();
        $genres = $stmt->fetchAll();
        return array_map(function ($genre) {
            return new Genre(
                new GenreId($genre['id']),
                new GenreName($genre['name'])
            );
        }, $genres);
    }

    public function save(Genre $genre): void
    {
        $sql = "INSERT INTO genres (id, name) VALUES (:id, :name) ON DUPLICATE KEY UPDATE name = :name";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $genre->id()->value(), PDO::PARAM_STR);
        $stmt->bindValue('name', $genre->name()->value(), PDO::PARAM_STR);
        $stmt->execute();        
    }

    public function remove(Genre $genre): void
    {
        $sql = "DELETE FROM genres WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $genre->id()->value(), PDO::PARAM_STR);
        $stmt->execute();

        if (!$stmt->rowCount()) {
            throw new GenreDoesNotExistException($genre->id());
        }
    }

    public function nextIdentity(): GenreId
    {
        return new GenreId(uniqid());
    }
}
