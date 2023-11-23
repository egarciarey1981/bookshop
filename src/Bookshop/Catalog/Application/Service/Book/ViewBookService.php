<?php

namespace Bookshop\Catalog\Application\Service\Book;

use Bookshop\Catalog\Application\Service\Book\BookService;
use Bookshop\Catalog\Domain\Model\Book\BookDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Book\BookId;

class ViewBookService extends BookService
{
    /** @return array<string,string|array<array<string,string>>> */
    public function execute(string $bookId): array
    {
        $book = $this->bookRepository->ofBookId(
            new BookId($bookId)
        );

        if ($book === null) {
            throw new BookDoesNotExistException(
                sprintf('Book with id `%s` does not exist', $bookId)
            );
        }

        return $book->toArray();
    }
}
