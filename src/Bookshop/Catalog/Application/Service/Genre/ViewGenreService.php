<?php

namespace Bookshop\Catalog\Application\Service\Genre;

use Bookshop\Catalog\Domain\Model\Genre\GenreDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;

class ViewGenreService extends GenreService
{
    public function execute(string $genreId): array
    {
        $genre = $this->genreRepository->ofGenreId(
            new GenreId($genreId),
        );

        if ($genre === null) {
            throw new GenreDoesNotExistException(
                sprintf('Genre with id `%s` does not exist', $genreId)
            );
        }

        return $genre->toArray();
    }
}
