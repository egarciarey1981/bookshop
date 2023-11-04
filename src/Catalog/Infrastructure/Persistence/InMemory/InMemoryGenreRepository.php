<?php

namespace Bookshop\Catalog\Infrastructure\Persistence\InMemory;

use Bookshop\Catalog\Domain\Genre\Genre;
use Bookshop\Catalog\Domain\Genre\GenreId;
use Bookshop\Catalog\Domain\Genre\GenreName;
use Bookshop\Catalog\Domain\Genre\GenreRepository;

class InMemoryBookRepository implements GenreRepository
{
    private $genres = [];

    public function __construct()
    {
        $this->genres = [
            ['id' => 'genre-01', 'name' => 'Genre Book 01'],
            ['id' => 'genre-02', 'name' => 'Genre Book 02'],
            ['id' => 'genre-03', 'name' => 'Genre Book 03'],
            ['id' => 'genre-04', 'name' => 'Genre Book 04'],
            ['id' => 'genre-05', 'name' => 'Genre Book 05'],
            ['id' => 'genre-06', 'name' => 'Genre Book 06'],
            ['id' => 'genre-07', 'name' => 'Genre Book 07'],
        ];
    }

    public function all(int $offset, int $limit): array
    {
        $result = [];

        foreach (array_slice($this->genres, $offset, $limit) as $genre) {
            $result[] = new Genre(
                new GenreId($genre['id']),
                new GenreName($genre['name'])
            );
        }
        return $result;
    }

    public function GenreOfId(GenreId $GenreId): ?Genre
    {
        foreach ($this->genres as $genre) {
            if ($genre['id'] === $GenreId->value()) {
                return new Genre(
                    new GenreId($genre['id']),
                    new GenreName($genre['name'])
                );
            }
        }

        return null;
    }

    public function save(Genre $genre): void
    {
        foreach ($this->genres as &$genreInMemory) {
            if ($genreInMemory['id'] === $genre->id()->value()) {
                $genreInMemory['name'] = $genre->name()->value();
                return;
            }
        }

        $this->genres[] = [
            'id' => $genre->id()->value(),
            'name' => $genre->name()->value()
        ];
    }

    public function remove(Genre $genre): void
    {
        foreach ($this->genres as $key => $genreInMemory) {
            if ($genreInMemory['id'] === $genre->id()->value()) {
                unset($this->genres[$key]);
                return;
            }
        }
    }

    public function nextIdentity(): GenreId
    {
        return new GenreId('genre-' . (count($this->genres) + 1));
    }
}