<?php

namespace Bookshop\Catalog\Application\Book\Create;

use Bookshop\Catalog\Domain\Book\Book;
use Bookshop\Catalog\Domain\Book\BookRepository;
use Bookshop\Catalog\Domain\Book\BookTitle;
use Bookshop\Catalog\Domain\Genre\GenresCollection;

class CreateBookService
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function __invoke(CreateBookRequest $request): CreateBookResponse
    {
        $bookId = $this->bookRepository->nextIdentity();
        $bookName = new BookTitle($request->bookTitle());
        $bookGenres = new GenresCollection();

        $book = new Book($bookId, $bookName, $bookGenres);

        $this->bookRepository->save($book);

        return new CreateBookResponse($book->toArray());
    }
}
