<?php

namespace Bookshop\Catalog\Application\Service\Book\Remove;

use Bookshop\Catalog\Domain\Model\Book\BookDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Book\BookId;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;

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
            throw new BookDoesNotExistException(
                sprintf('Book with id `%s` does not exist', $bookId->value())
            );
        }

        if ($this->bookRepository->remove($book) === false) {
            throw new \Exception('Book could not be removed');
        }
    }
}
