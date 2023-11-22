<?php

namespace Bookshop\Catalog\Application\Service\Genre;

use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Bookshop\Catalog\Domain\Model\Genre\GenreDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;

class UpdateGenreService extends GenreService
{
    public function execute(string $genreId, string $genreName)
    {
        $genre = $this->genreRepository->ofGenreId(
            new GenreId($genreId),
        );

        if ($genre === null) {
            throw new GenreDoesNotExistException(
                sprintf('Genre with id `%s` does not exist', $genreId)
            );
        }

        $genre = new Genre(
            new GenreId($genreId),
            new GenreName($genreName)
        );

        if ($this->genreRepository->save($genre) === false) {
            throw new \Exception('Genre could not be updated');
        }
    }
}
