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
    public function all(int $offset, int $limit): array
    {
        $sql = 'SELECT * FROM genres LIMIT :limit OFFSET :offset';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $genres = $stmt->fetchAll();
        return array_map(function ($genre) {
            return new Genre(
                new GenreId($genre['id']),
                new GenreName($genre['name'])
            );
        }, $genres);
    }

    public function genreOfId(GenreId $id): Genre
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
