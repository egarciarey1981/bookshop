<?php

namespace Bookshop\Catalog\Application\Service\Book;

use Bookshop\Catalog\Domain\Model\Book\Book;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;
use Bookshop\Catalog\Domain\Model\Book\BookTitle;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;

class CreateBookService extends BookService
{
    public function __construct(
        protected readonly BookRepository $bookRepository,
        protected readonly GenreRepository $genreRepository
    ) {
    }

    public function execute(string $bookTitle, array $bookGenreIds): array
    {
        $genresBook = $this->genreRepository->ofGenreIds(
            array_map(
                fn (string $genreId) => new GenreId($genreId),
                $bookGenreIds
            )
        );

        $book = new Book(
            $this->bookRepository->nextIdentity(),
            new BookTitle($bookTitle),
            $genresBook
        );

        if ($this->bookRepository->insert($book) === false) {
            throw new \Exception('Book could not be created');
        }

        return $book->toArray();
    }
}
