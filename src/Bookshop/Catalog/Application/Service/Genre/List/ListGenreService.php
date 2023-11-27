<?php

namespace Bookshop\Catalog\Application\Service\Genre\List;

use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;

final class ListGenreService
{
    private GenreRepository $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function execute(ListGenreRequest $request): ListGenreResponse
    {
        $offset = $request->offset();
        $limit = $request->limit();
        $filter = $request->filter();

        $genres = $this->genreRepository->all($offset, $limit, $filter);
        $total = $this->genreRepository->count($filter);

        array_walk($genres, function (&$genre) {
            $genre = [
                'id' => $genre->genreId()->value(),
                'name' => $genre->genreName()->value(),
                'number_of_books' => $genre->numberOfBooks()->value(),
            ];
        });

        return new ListGenreResponse($total, $genres);
    }
}
