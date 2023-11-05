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

        $data['total'] = $this->genreRepository->count($filter);

        foreach ($genres as $genre) {
            $data['genres'][] = [
                'id' => $genre->id()->value(),
                'name' => $genre->name()->value(),
            ];
        }

        return new ListGenresResponse($data);
    }
}