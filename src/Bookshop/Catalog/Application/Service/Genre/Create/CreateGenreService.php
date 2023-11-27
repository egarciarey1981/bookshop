<?php

namespace Bookshop\Catalog\Application\Service\Genre\Create;

use Bookshop\Catalog\Domain\Model\Genre\Genre;
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

        $genre = Genre::fromPrimitives($genreId->value(), $request->name(), 0);

        $this->genreRepository->insert($genre);

        return new CreateGenreResponse($genreId->value());
    }
}
