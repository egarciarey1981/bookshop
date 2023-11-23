<?php

namespace Bookshop\Catalog\Application\Service\Genre;

use Bookshop\Catalog\Domain\Model\Genre\Genre;

class ListGenreService extends GenreService
{
    /** @return array<string,int|array<array<string,string>>> */
    public function execute(int $offset, int $limit, string $filter): array
    {
        $total = $this->genreRepository->count($filter);
        $genres = $this->genreRepository->all($offset, $limit, $filter);

        return [
            'total' => $total,
            'genres' => array_map(
                fn (Genre $genre) => $genre->toArray(),
                $genres
            ),
        ];
    }
}
