<?php

namespace Bookshop\Catalog\Application\Genre\Update;

use Bookshop\Catalog\Domain\Genre\Genre;
use Bookshop\Catalog\Domain\Genre\GenreDoesNotExistException;
use Bookshop\Catalog\Domain\Genre\GenreId;
use Bookshop\Catalog\Domain\Genre\GenreName;
use Bookshop\Catalog\Domain\Genre\GenreRepository;

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
            throw new GenreDoesNotExistException($genreId);
        }

        $genre = new Genre($genreId, $genreName);

        $this->genreRepository->save($genre);
    }
}
