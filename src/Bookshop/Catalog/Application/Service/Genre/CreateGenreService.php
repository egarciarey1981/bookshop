<?php

namespace Bookshop\Catalog\Application\Service\Genre;

use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;
use Exception;

class CreateGenreService extends GenreService
{
    /** @return array<string,string> */
    public function execute(string $genreName): array
    {
        $genre = new Genre(
            $this->genreRepository->nextIdentity(),
            new GenreName($genreName)
        );

        if ($this->genreRepository->insert($genre) === false) {
            throw new  Exception('Genre could not be created');
        }

        return $genre->toArray();
    }
}
