<?php

namespace Bookshop\Catalog\Application\Service\Genre\Create;

use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;
use Bookshop\Catalog\Domain\Model\Genre\GenreNumberOfBooks;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;

class CreateGenreService
{
    private GenreRepository $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function execute(CreateGenreRequest $request): CreateGenreResponse
    {
        $genreId = $this->genreRepository->nextIdentity();
        $genreName = new GenreName($request->genreName());
        $genreNumberOfBooks = new GenreNumberOfBooks();

        $genre = new Genre($genreId, $genreName, $genreNumberOfBooks);
        $this->genreRepository->insert($genre);

        return new CreateGenreResponse($genre->toArray());
    }
}
