<?php

namespace Bookshop\Catalog\Domain\Genre;

interface GenreRepository
{
    public function nextIdentity(): GenreId;
    public function all(int $offset, int $limit): array;
    public function genreOfId(GenreId $id): ?Genre;
    public function save(Genre $genre): void;
    public function remove(Genre $genre): void;
}
