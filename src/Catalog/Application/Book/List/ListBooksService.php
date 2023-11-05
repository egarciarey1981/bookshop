<?php

namespace Bookshop\Catalog\Application\Book\List;

use Bookshop\Catalog\Domain\Book\BookRepository;

class ListBooksService
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function __invoke(ListBooksRequest $request): ListBooksResponse
    {
        $limit = $request->limit();
        $offset = $request->offset();
        $filter = $request->filter();

        $books = $this->bookRepository->all($offset, $limit, $filter);

        $data['total'] = $this->bookRepository->count($filter);

        foreach ($books as $genre) {
            $data['books'][] = [
                'id' => $genre->id()->value(),
                'title' => $genre->title()->value(),
            ];
        }

        return new ListBooksResponse($data);
    }
}
