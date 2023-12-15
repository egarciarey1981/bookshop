<?php

namespace Bookshop\Catalog\Application\Service\Genre\Remove;

use Bookshop\Catalog\Domain\Model\Genre\GenreDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;

class RemoveGenreService
{
    private GenreRepository $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function execute(RemoveGenreRequest $request): void
    {
        $genreId = new GenreId($request->genreId());

        $genre = $this->genreRepository->ofGenreId($genreId);

        if ($genre === null) {
            throw new GenreDoesNotExistException();
        }

        $this->genreRepository->remove($genre);
    }
}
