<?php

namespace Bookshop\Catalog\Application\Service\Genre\View;

use Bookshop\Catalog\Domain\Model\Genre\GenreDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;

final class ViewGenreService
{
    private GenreRepository $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function execute(ViewGenreRequest $request): ViewGenreResponse
    {
        $genreId = new GenreId($request->id());

        $genre = $this->genreRepository->ofGenreId($genreId);

        if ($genre === null) {
            throw new GenreDoesNotExistException();
        }

        return new ViewGenreResponse(
            $genre->genreId()->value(),
            $genre->genreName()->value(),
            $genre->numberOfBooks()->value(),
        );
    }
}
