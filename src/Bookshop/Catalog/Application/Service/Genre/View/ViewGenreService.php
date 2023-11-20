<?php

namespace Bookshop\Catalog\Application\Service\Genre\View;

use Bookshop\Catalog\Domain\Model\Genre\GenreDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;

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
            throw new GenreDoesNotExistException(
                sprintf('Genre with id `%s` does not exist', $genreId->value())
            );
        }

        return new ViewGenreResponse($genre->toArray());
    }
}
