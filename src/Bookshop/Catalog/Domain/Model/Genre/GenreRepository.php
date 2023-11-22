<?php

namespace Bookshop\Catalog\Domain\Model\Genre;

interface GenreRepository
{
    public function nextIdentity(): GenreId;
    public function all(int $offset, int $limit, string $filter): array;
    public function count(string $filter): int;
    public function ofGenreId(GenreId $genreId): ?Genre;
    public function ofGenreIds(array $genreIds): array;
    public function insert(Genre $genre): bool;
    public function update(Genre $genre): bool;
    public function remove(Genre $genre): bool;
}
