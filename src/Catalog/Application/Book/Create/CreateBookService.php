<?php

namespace Bookshop\Catalog\Application\Book\Create;

use Bookshop\Catalog\Domain\Book\Book;
use Bookshop\Catalog\Domain\Book\BookRepository;

class CreateBookService
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }
    
    public function __invoke(CreateBookRequest $request): CreateBookResponse
    {
        $book = new Book(
            $this->bookRepository->nextIdentity(),
            $request->bookTitle(),
        );

        $this->bookRepository->insert($book);

        return new CreateBookResponse($book);
    }
}
