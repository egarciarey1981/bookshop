<?php

namespace Bookshop\Catalog\Application\Book\List;

use Bookshop\Catalog\Domain\Book\BookRepository;

class ListBooksService
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository) {
        $this->bookRepository = $bookRepository;
    }

    public function __invoke(ListBooksRequest $request): ListBooksResponse
    {
        $limit = $request->limit();
        $offset = $request->offset();
        $filter = $request->filter();

        $booksEntities = $this->bookRepository->all($offset, $limit, $filter);

        $data['total'] = $this->bookRepository->count($filter);

        foreach ($booksEntities as $book) {
            $data['book'][] = $book->toArray();
        }

        return new ListBooksResponse($data['book'], $data['total']);
    }
}
