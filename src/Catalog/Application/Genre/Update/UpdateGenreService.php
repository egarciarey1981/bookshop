<?php

namespace Bookshop\Catalog\Application\Genre\Update;

use Bookshop\Catalog\Domain\Genre\Genre;
use Bookshop\Catalog\Domain\Genre\GenreDoesNotExistException;
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
        $genre = $this->genreRepository->ofGenreId(
            $request->genreId()
        );

        if ($genre === null) {
            throw new GenreDoesNotExistException($request->genreId());
        }

        $genre = new Genre(
            $request->genreId(),
            $request->genreName(),
        );

        $this->genreRepository->save($genre);
    }
}
