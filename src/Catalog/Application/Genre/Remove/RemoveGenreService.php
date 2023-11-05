<?php

namespace Bookshop\Catalog\Application\Genre\Remove;

use Bookshop\Catalog\Domain\Genre\GenreDoesNotExistException;
use Bookshop\Catalog\Domain\Genre\GenreRepository;

class RemoveGenreService
{
    private GenreRepository $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }
    
    public function __invoke(RemoveGenreRequest $request)
    {
        $genre = $this->genreRepository->ofGenreId(
            $request->genreId()
        );

        if ($genre === null) {
            throw new GenreDoesNotExistException($request->genreId());
        }

        $this->genreRepository->remove($genre);
    }
}
