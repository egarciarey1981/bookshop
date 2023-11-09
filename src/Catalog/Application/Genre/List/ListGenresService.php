<?php

namespace Bookshop\Catalog\Application\Genre\List;

use Bookshop\Catalog\Domain\Genre\GenreRepository;

class ListGenresService
{
    private GenreRepository $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function __invoke(ListGenresRequest $request): ListGenresResponse
    {
        $offset = $request->offset();
        $limit = $request->limit();
        $filter = $request->filter();

        $genres = $this->genreRepository->all($offset, $limit, $filter);

        array_walk($genres, function (&$genre) {
            $genre = $genre->toArray();
        });

        $total = $this->genreRepository->count($filter);

        return new ListGenresResponse($genres, $total);
    }
}
