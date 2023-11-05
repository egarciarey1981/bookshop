<?php

namespace Bookshop\Catalog\Application\Book\View;

use Bookshop\Catalog\Domain\Book\BookDoesNotExistException;
use Bookshop\Catalog\Domain\Book\BookRepository;
use Bookshop\Catalog\Domain\BookGenre\BookGenreRepository;
use Bookshop\Catalog\Domain\Genre\GenreRepository;

class ViewBookService
{
    private BookRepository $bookRepository;
    private GenreRepository $genreRepository;
    private BookGenreRepository $bookGenreRepository;

    public function __construct(
        BookRepository $bookRepository,
        GenreRepository $genreRepository,
        BookGenreRepository $bookGenreRepository,
    )
    {
        $this->bookRepository = $bookRepository;
        $this->genreRepository = $genreRepository;
        $this->bookGenreRepository = $bookGenreRepository;
    }
    
    public function __invoke(ViewBookRequest $request): ViewBookResponse
    {
        $book = $this->bookRepository->ofBookId(
            $request->bookId(),
        );

        if ($book === null) {
            throw new BookDoesNotExistException(
                $request->bookId(),
            );
        }

        $booksGenres = $this->bookGenreRepository->ofBookId(
            $request->bookId(),
        );

        $genres = $this->genreRepository->ofGenreIds(
            array_map(
                fn ($bookGenre) => $bookGenre->genreId(),
                $booksGenres,
            ),
        );

        return new ViewBookResponse($book, ...$genres);
    }
}