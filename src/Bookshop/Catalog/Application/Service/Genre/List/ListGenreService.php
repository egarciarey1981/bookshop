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
        $total = $this->genreRepository->count($request->filter());
        $genreCollection = $this->genreRepository->all(
            $request->offset(),
            $request->limit(),
            $request->filter()
        );

        return new ListGenreResponse($total, $genreCollection->toArray());
    }
}
