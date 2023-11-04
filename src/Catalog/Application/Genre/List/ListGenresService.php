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
        $genres = $this->genreRepository->all(
            $request->offset(),
            $request->limit(),
        );

        return new ListGenresResponse(...$genres);
    }
}