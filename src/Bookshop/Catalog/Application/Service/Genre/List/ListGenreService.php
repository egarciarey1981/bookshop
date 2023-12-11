<?php

namespace Bookshop\Catalog\Application\Service\Genre\List;

use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;

class ListGenreService
{
    private GenreRepository $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function execute(ListGenreRequest $request): ListGenreResponse
    {
        $total = $this->genreRepository->count($request->filter());
        $genres = $this->genreRepository->all(
            $request->offset(),
            $request->limit(),
            $request->filter(),
        );

        array_walk($genres, function (&$genre) {
            $genre = [
                'id' => $genre->genreId()->value(),
                'name' => $genre->genreName()->value(),
                'number_of_books' => $genre->genreNumberOfBooks()->value(),
            ];
        });

        return new ListGenreResponse($total, $genres);
    }
}
