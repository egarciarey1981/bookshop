<?php

namespace Bookshop\Catalog\Application\Service\Book;

use Bookshop\Catalog\Domain\Model\Book\BookDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Book\BookId;
use Exception;

class RemoveBookService extends BookService
{
    public function execute(string $bookId)
    {
        $book = $this->bookRepository->ofBookId(
            new BookId($bookId)
        );

        if ($book === null) {
            throw new BookDoesNotExistException(
                sprintf('Book with id `%s` does not exist', $bookId)
            );
        }

        if ($this->bookRepository->remove($book) === false) {
            throw new Exception('Book could not be removed');
        }
    }
}
