<?php

namespace Bookshop\Catalog\Application\Service\Genre\Create;

use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;

class CreateGenreService
{
    private GenreRepository $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function __invoke(CreateGenreRequest $request): CreateGenreResponse
    {
        $genreId = $this->genreRepository->nextIdentity();
        $genreName = new GenreName($request->genreName());

        $genre = new Genre($genreId, $genreName);

        if ($this->genreRepository->save($genre) === false) {
            throw new  \Exception('Genre could not be created');
        } else {
            return new CreateGenreResponse($genre->toArray());
        }        
    }
}
