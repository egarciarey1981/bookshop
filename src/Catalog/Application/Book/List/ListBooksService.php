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
        $books = $this->bookRepository->all(
            $request->offset(),
            $request->limit(),
        );

        return new ListBooksResponse(...$books);
    }
}