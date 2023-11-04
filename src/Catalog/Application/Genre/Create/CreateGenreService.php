<?php

namespace Bookshop\Catalog\Application\Genre\Create;

use Bookshop\Catalog\Domain\Genre\Genre;
use Bookshop\Catalog\Domain\Genre\GenreRepository;

class CreateGenreService
{
    private GenreRepository $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }
    
    public function __invoke(CreateGenreRequest $request): CreateGenreResponse
    {
        $genre = new Genre(
            $this->genreRepository->nextIdentity(),
            $request->genreName(),
        );

        $this->genreRepository->save($genre);

        return new CreateGenreResponse($genre);
    }
}
