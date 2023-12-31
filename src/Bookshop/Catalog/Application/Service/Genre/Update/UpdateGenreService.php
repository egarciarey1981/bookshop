<?php

namespace Bookshop\Catalog\Application\Service\Genre\Update;

use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Bookshop\Catalog\Domain\Model\Genre\GenreDoesNotExistException;
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
        $genreId = new GenreId($request->id());
        $genreName = new GenreName($request->name());

        $genre = $this->genreRepository->ofGenreId($genreId);

        if ($genre === null) {
            throw new GenreDoesNotExistException();
        }

        $genre = new Genre(
            $genreId,
            $genreName,
            $genre->genreNumberOfBooks(),
        );

        $this->genreRepository->update($genre);
    }
}
