<?php

namespace Bookshop\Catalog\Domain\Model\Genre;

interface GenreRepository
{
    public function nextIdentity(): GenreId;
    public function all(int $offset, int $limit, string $filter): GenreCollection;
    public function count(string $filter): int;
    public function ofGenreId(GenreId $genreId): Genre;
    public function ofGenreIds(GenreId ...$genreIds): GenreCollection;
    public function insert(Genre $genre): void;
    public function update(Genre $genre): void;
    public function remove(Genre $genre): void;
    public function updateNumberOfBooksByGenreService(): void;
}
