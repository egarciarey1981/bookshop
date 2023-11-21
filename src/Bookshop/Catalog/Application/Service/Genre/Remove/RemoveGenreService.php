<?php

namespace Bookshop\Catalog\Application\Service\Genre\Remove;

use Bookshop\Catalog\Domain\Model\Genre\GenreDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;

class RemoveGenreService
{
    private GenreRepository $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function __invoke(RemoveGenreRequest $request)
    {
        $genreId = new GenreId($request->genreId());

        $genre = $this->genreRepository->ofGenreId($genreId);

        if ($genre === null) {
            throw new GenreDoesNotExistException(
                sprintf('Genre with id `%s` does not exist', $genreId->value())
            );
        }

        if ($this->genreRepository->remove($genre) === false) {
            throw new \Exception('Genre could not be removed');
        }
    }
}
