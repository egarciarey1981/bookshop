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

        $data['total'] = $this->genreRepository->count($filter);

        foreach ($genresEntities as $genre) {
            $data['genres'][] = $genre->toArray();
        }

        return new ListGenresResponse($data['genres'], $data['total']);
    }
}