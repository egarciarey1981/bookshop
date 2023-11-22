<?php

namespace Bookshop\Catalog\Application\Service\Genre;

use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;

class CreateGenreService extends GenreService
{
    public function execute(string $genreName): array
    {
        $genre = new Genre(
            $this->genreRepository->nextIdentity(),
            new GenreName($genreName)
        );

        if ($this->genreRepository->insert($genre) === false) {
            throw new  \Exception('Genre could not be created');
        }

        return $genre->toArray();
    }
}
