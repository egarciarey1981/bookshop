<?php

namespace Bookshop\Catalog\Application\Book\List;

use Bookshop\Catalog\Domain\Book\BookRepository;
use Bookshop\Catalog\Domain\Genre\GenreRepository;

class ListBooksService
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

        return new ListBooksResponse($booksData, $total);
    }
}
