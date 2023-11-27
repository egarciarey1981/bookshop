<?php

namespace Bookshop\Catalog\Application\Service\Genre\Remove;

use Bookshop\Catalog\Domain\Model\Genre\GenreDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;

class RemoveGenreService
{
    private GenreRepository $service;

    public function __construct(GenreRepository $service)
    {
        $this->service = $service;
    }

    public function execute(RemoveGenreRequest $request): void
    {
        $genreId = new GenreId($request->genreId());

        $genre = $this->service->ofGenreId($genreId);

        if ($genre === null) {
            throw new GenreDoesNotExistException();
        }

        $this->service->remove($genre);
    }
}
