<?php

namespace Bookshop\Catalog\Application\Service\Book;

use Bookshop\Catalog\Domain\Model\Book\Book;
use Bookshop\Catalog\Domain\Model\Book\BookDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Book\BookId;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;
use Bookshop\Catalog\Domain\Model\Book\BookTitle;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use Exception;

class UpdateBookService extends BookService
{
    public function __construct(
        protected readonly BookRepository $bookRepository,
        protected readonly GenreRepository $genreRepository
    ) {
    }

    /** @param array<string> $bookGenreIds */
    public function execute(string $bookId, string $bookTitle, array $bookGenreIds): void
    {

        $book = $this->bookRepository->ofBookId(
            new BookId($bookId)
        );

        if ($book === null) {
            throw new BookDoesNotExistException(
                sprintf('Book with id `%s` does not exist', $bookId)
            );
        }

        $genresBook = $this->genreRepository->ofGenreIds(
            array_map(
                fn (string $genreId) => new GenreId($genreId),
                $bookGenreIds
            )
        );

        $book = new Book(
            new BookId($bookId),
            new BookTitle($bookTitle),
            $genresBook
        );

        if ($this->bookRepository->update($book) === false) {
            throw new Exception('Book could not be updated');
        }
    }
}
