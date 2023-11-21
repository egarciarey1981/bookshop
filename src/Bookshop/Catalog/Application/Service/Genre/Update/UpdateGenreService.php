<?php

namespace Bookshop\Catalog\Application\Service\Genre\Update;

use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Bookshop\Catalog\Domain\Model\Genre\GenreDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;

class UpdateGenreService
{
    private GenreRepository $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function __invoke(UpdateGenreRequest $request)
    {
        $genreId = new GenreId($request->genreId());
        $genreName = new GenreName($request->genreName());

        $genre = $this->genreRepository->ofGenreId($genreId);

        if ($genre === null) {
            throw new GenreDoesNotExistException(
                sprintf('Genre with id `%s` does not exist', $genreId->value())
            );
        }

        $genre = new Genre($genreId, $genreName);

        if ($this->genreRepository->save($genre) === false) {
            throw new \Exception('Genre could not be updated');
        }
    }
}
