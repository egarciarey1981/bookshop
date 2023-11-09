<?php

namespace Bookshop\Catalog\Application\Genre\View;

use Bookshop\Catalog\Domain\Genre\GenreDoesNotExistException;
use Bookshop\Catalog\Domain\Genre\GenreId;
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
        $genreId = new GenreId($request->genreId());

        $genre = $this->genreRepository->ofGenreId($genreId);

        if ($genre === null) {
            throw new GenreDoesNotExistException($genreId);
        }

        $data['genre'] = $genre->toArray();

        return new ViewGenreResponse($data['genre']);
    }
}