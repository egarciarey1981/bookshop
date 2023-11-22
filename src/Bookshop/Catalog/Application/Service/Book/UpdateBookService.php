<?php

namespace Bookshop\Catalog\Application\Service\Book;

use Bookshop\Catalog\Domain\Model\Book\Book;
use Bookshop\Catalog\Domain\Model\Book\BookDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Book\BookId;
use Bookshop\Catalog\Domain\Model\Book\BookTitle;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;

class UpdateBookService extends BookService
{
    public function execute(string $bookId, string $bookTitle, array $bookGenreIds)
    {
        $book = $this->bookRepository->ofBookId(
            new BookId($bookId)
        );

        if ($book === null) {
            throw new BookDoesNotExistException(
                sprintf('Book with id `%s` does not exist', $bookId)
            );
        }

        $book = new Book(
            new BookId($bookId),
            new BookTitle($bookTitle),
            array_map(
                fn (string $genreId) => new GenreId($genreId),
                $bookGenreIds
            )
        );

        if ($this->bookRepository->update($book) === false) {
            throw new \Exception('Book could not be updated');
        }
    }
}
