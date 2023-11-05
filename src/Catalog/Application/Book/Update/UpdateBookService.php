<?php

namespace Bookshop\Catalog\Application\Book\Update;

use Bookshop\Catalog\Domain\Book\Book;
use Bookshop\Catalog\Domain\Book\BookDoesNotExistException;
use Bookshop\Catalog\Domain\Book\BookRepository;

class UpdateBookService
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }
    
    public function __invoke(UpdateBookRequest $request)
    {
        $book = $this->bookRepository->ofBookId(
            $request->bookId()
        );

        if ($book === null) {
            throw new BookDoesNotExistException($request->bookId());
        }

        $book = new Book(
            $request->bookId(),
            $request->bookTitle(),
        );

        $this->bookRepository->save($book);
    }
}
