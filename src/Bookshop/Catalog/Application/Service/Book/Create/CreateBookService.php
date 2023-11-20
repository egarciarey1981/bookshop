<?php

namespace Bookshop\Catalog\Application\Service\Book\Create;

use Bookshop\Catalog\Domain\Model\Book\Book;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;
use Bookshop\Catalog\Domain\Model\Book\BookTitle;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use Bookshop\Catalog\Domain\Model\Genre\GenresCollection;

class CreateBookService
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

    public function __invoke(CreateBookRequest $request): CreateBookResponse
    {
        $bookId = $this->bookRepository->nextIdentity();
        $bookName = new BookTitle($request->bookTitle());
        $bookGenres = new GenresCollection(
            ...array_map(
                fn (string $genreId) => $this->genreRepository->ofGenreId(new GenreId($genreId)),
                $request->bookGenreIds()
            )
        );

        $book = new Book($bookId, $bookName, $bookGenres);

        $this->bookRepository->save($book);

        return new CreateBookResponse($book->toArray());
    }
}
