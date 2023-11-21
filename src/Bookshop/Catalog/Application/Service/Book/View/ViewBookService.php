<?php

namespace Bookshop\Catalog\Application\Service\Book\View;

use Bookshop\Catalog\Domain\Model\Book\BookDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Book\BookId;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;

class ViewBookService
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function __invoke(ViewBookRequest $request): ViewBookResponse
    {
        $bookId = new BookId($request->bookId());

        $book = $this->bookRepository->ofBookId($bookId);

        if ($book === null) {
            throw new BookDoesNotExistException(
                sprintf('Book with id `%s` does not exist', $bookId->value())
            );
        }

        return new ViewBookResponse($book->toArray());
    }
}
