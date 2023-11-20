<?php

namespace Bookshop\Catalog\Application\Book\Update;

use Bookshop\Catalog\Domain\Model\Book\Book;
use Bookshop\Catalog\Domain\Model\Book\BookDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Book\BookId;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;
use Bookshop\Catalog\Domain\Model\Book\BookTitle;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use Bookshop\Catalog\Domain\Model\Genre\GenresCollection;

class UpdateBookService
{
    private BookRepository $bookRepository;
    private GenreRepository $genreRepository;

    public function __construct(
        BookRepository $bookRepository,
        GenreRepository $genreRepository,
    ) {
        $this->bookRepository = $bookRepository;
        $this->genreRepository = $genreRepository;
    }

    public function __invoke(UpdateBookRequest $request)
    {
        $bookId = new BookId($request->bookId());
        $bookTitle = new BookTitle($request->bookTitle());
        $bookGenres = new GenresCollection(
            ...array_map(
                fn (string $genreId) => $this->genreRepository->ofGenreId(new GenreId($genreId)),
                $request->bookGenreIds()
            )
        );

        $book = $this->bookRepository->ofBookId($bookId);

        if ($book === null) {
            throw new BookDoesNotExistException($bookId);
        }

        $book = new Book($bookId, $bookTitle, $bookGenres);

        $this->bookRepository->save($book);
    }
}
