<?php

namespace Bookshop\Catalog\Application\Genre\View;

use Bookshop\Catalog\Domain\Genre\GenreDoesNotExistException;
use Bookshop\Catalog\Domain\Genre\GenreRepository;

class ViewGenreService
{
    private GenreRepository $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }
    
    public function __invoke(ViewGenreRequest $request): ViewGenreResponse
    {
        $genre = $this->genreRepository->genreOfId(
            $request->genreId(),
        );

        if ($genre === null) {
            throw new GenreDoesNotExistException(
                $request->genreId(),
            );
        }

        return new ViewGenreResponse($genre);
    }
}