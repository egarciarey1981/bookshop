<?php

namespace Bookshop\Catalog\Application\Service\Genre\Update;

use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;

class UpdateGenreService
{
    private GenreRepository $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function execute(UpdateGenreRequest $request): void
    {
        $genreId = new GenreId($request->genreId());
        $genreName = new GenreName($request->genreName());

        $oldGenre = $this->genreRepository->ofGenreId($genreId);
        $newGenre = new Genre($genreId, $genreName, $oldGenre->numberOfBooks());

        $this->genreRepository->update($newGenre);
    }
}
