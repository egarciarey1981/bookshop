<?php

namespace Bookshop\Catalog\Application\Service\Genre;

class ListGenreService extends GenreService
{
    public function execute(int $offset, int $limit, string $filter): array
    {
        $total = $this->genreRepository->count($filter);
        $genres = $this->genreRepository->all($offset, $limit, $filter);

        array_walk($genres, function (&$genre) {
            $genre = $genre->toArray();
        });

        return [
            'total' => $total,
            'genres' => $genres,
        ];
    }
}
