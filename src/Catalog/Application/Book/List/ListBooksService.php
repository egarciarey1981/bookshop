<?php

namespace Bookshop\Catalog\Application\Book\List;

use Bookshop\Catalog\Domain\Book\BookRepository;
use Bookshop\Catalog\Domain\BookGenre\BookGenreRepository;
use Bookshop\Catalog\Domain\Genre\GenreRepository;

class ListBooksService
{
    private BookRepository $bookRepository;
    private BookGenreRepository $bookGenreRepository;
    private GenreRepository $genreRepository;

    public function __construct(
        BookRepository $bookRepository,
        BookGenreRepository $bookGenreRepository,
        GenreRepository $genreRepository,
    ) {
        $this->bookRepository = $bookRepository;
        $this->bookGenreRepository = $bookGenreRepository;
        $this->genreRepository = $genreRepository;
    }

    public function __invoke(ListBooksRequest $request): ListBooksResponse
    {
        $limit = $request->limit();
        $offset = $request->offset();
        $filter = $request->filter();

        $booksEntities = $this->bookRepository->all($offset, $limit, $filter);

        $total = $this->bookRepository->count($filter);

        $booksData = [];

        foreach ($booksEntities as $book) {
            $booksData[] = [
                'id' => $book->id()->value(),
                'title' => $book->title()->value(),
                'genres' => [],
            ];
        }

        $this->addGenres($booksEntities, $booksData);

        return new ListBooksResponse($booksData, $total);
    }

    private function addGenres($booksEntities, &$booksData)
    {
        $booksIds = array_map(
            fn ($bookEntity) => $bookEntity->id(),
            $booksEntities,
        );

        $booksGenres = $this->bookGenreRepository->ofBookIds($booksIds);

        $genresIds = array_map(
            fn ($bookGenre) => $bookGenre->genreId(),
            $booksGenres,
        );

        $genres = $this->genreRepository->ofGenreIds($genresIds);

        foreach ($booksData as &$bookData) {
            $genresOfThisBook = array_filter(
                $booksGenres,
                fn ($bookGenre) => $bookGenre->bookId()->value() === $bookData['id'],
            );

            foreach ($genresOfThisBook as $bookGenre) {
                foreach ($genres as $genre) {
                    if ($bookGenre->genreId()->value() == $genre->id()->value()) {
                        $bookData['genres'][] = [
                            'id' => $genre->id()->value(),
                            'name' => $genre->name()->value(),
                        ];
                    }
                }
            }
        }
    }
}
