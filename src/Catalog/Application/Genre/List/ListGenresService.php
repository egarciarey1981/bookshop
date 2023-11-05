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

        $genresEntities = $this->genreRepository->all($offset, $limit, $filter);

        $total = $this->genreRepository->count($filter);

        $genresData = [];

        foreach ($genresEntities as $genreEntity) {
            $genresData[] = [
                'id' => $genreEntity->id()->value(),
                'name' => $genreEntity->name()->value(),
            ];
        }

        return new ListGenresResponse($genresData, $total);
    }
}