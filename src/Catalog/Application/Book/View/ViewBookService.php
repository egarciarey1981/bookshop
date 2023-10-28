<?php

namespace Bookshop\Catalog\Application\Book\View;

use Bookshop\Catalog\Domain\Book\BookId;
use Bookshop\Catalog\Domain\Book\BookRepository;

class ViewBookService
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }
    
    public function __invoke(ViewBookRequest $request): ViewBookResponse
    {
        $book = $this->bookRepository->ofId(
            $request->bookId(),
        );

        return new ViewBookResponse($book);
    }
}