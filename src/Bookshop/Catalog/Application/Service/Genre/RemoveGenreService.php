<?php

namespace Bookshop\Catalog\Application\Service\Genre;

use Bookshop\Catalog\Application\Service\Genre\GenreService;
use Bookshop\Catalog\Domain\Model\Genre\GenreDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;

class RemoveGenreService extends GenreService
{
    public function execute(string $genreId)
    {
        $genre = $this->genreRepository->ofGenreId(
            new GenreId($genreId),
        );

        if ($genre === null) {
            throw new GenreDoesNotExistException(
                sprintf('Genre with id `%s` does not exist', $genreId)
            );
        }

        if ($this->genreRepository->remove($genre) === false) {
            throw new \Exception('Genre could not be removed');
        }
    }
}
