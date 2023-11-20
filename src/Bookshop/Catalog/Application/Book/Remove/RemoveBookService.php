<?php

namespace Bookshop\Catalog\Application\Book\Remove;

use Bookshop\Catalog\Domain\Book\BookDoesNotExistException;
use Bookshop\Catalog\Domain\Book\BookId;
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
        $bookId = new BookId($request->bookId());

        $book = $this->bookRepository->ofBookId($bookId);

        if ($book === null) {
            throw new BookDoesNotExistException($bookId);
        }

        $this->bookRepository->remove($book);
    }
}
