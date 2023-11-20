<?php

namespace Bookshop\Catalog\Application\Book\List;

use Bookshop\Catalog\Domain\Model\Book\BookRepository;

class ListBooksService
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function __invoke(ListBooksRequest $request): ListBooksResponse
    {
        $offset = $request->offset();
        $limit = $request->limit();
        $filter = $request->filter();

        $books = $this->bookRepository->all($offset, $limit, $filter);

        array_walk($books, function (&$book) {
            $book = $book->toArray();
        });

        $total = $this->bookRepository->count($filter);

        return new ListBooksResponse($books, $total);
    }
}
