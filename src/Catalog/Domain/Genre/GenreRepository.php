<?php

namespace Bookshop\Catalog\Domain\Genre;

interface GenreRepository
{
    public function nextIdentity(): GenreId;
    public function all(int $offset, int $limit, string $filter): array;
    public function count(string $filter): int;
    public function ofGenreId(GenreId $genreId): ?Genre;
    public function ofGenreIds(array $genreIds): array;
    public function save(Genre $genre): void;
    public function remove(Genre $genre): void;
}
