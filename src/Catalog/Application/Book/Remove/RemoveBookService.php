<?php

namespace Bookshop\Catalog\Application\Book\Remove;

use Bookshop\Catalog\Domain\Book\BookDoesNotExistException;
use Bookshop\Catalog\Domain\Book\BookRepository;

class RemoveBookService
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }
    
    public function __invoke(RemoveBookRequest $request)
    {
        $book = $this->bookRepository->bookOfId(
            $request->bookId()
        );

        if ($book === null) {
            throw new BookDoesNotExistException($request->bookId());
        }

        $this->bookRepository->remove($book);
    }
}
