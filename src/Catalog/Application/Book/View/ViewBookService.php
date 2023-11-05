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

        $data['book'] = [
            'id' => $book->id()->value(),
            'title' => $book->title()->value(),
            'genres' => [],
        ];

        $this->addGenres($book, $data);

        return new ViewBookResponse($data);
    }

    private function addGenres($book, &$data)
    {
        $booksGenres = $this->bookGenreRepository->ofBookId($book->id());

        $genresIds = array_map(
            fn ($bookGenre) => $bookGenre->genreId(),
            $booksGenres,
        );

        $genres = $this->genreRepository->ofGenreIds($genresIds);

        foreach ($genres as $genre) {
            $data['book']['genres'][] = [
                'id' => $genre->id()->value(),
                'name' => $genre->name()->value(),
            ];
        }
    }
}