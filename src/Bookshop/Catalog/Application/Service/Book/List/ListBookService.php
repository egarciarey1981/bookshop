<?php

namespace Bookshop\Catalog\Application\Service\Book\List;

use Bookshop\Catalog\Application\Service\Book\List\ListBookRequest;
use Bookshop\Catalog\Application\Service\Book\List\ListBookResponse;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;

class ListBookService
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function execute(ListBookRequest $request): ListBookResponse
    {
        $total = $this->bookRepository->count($request->filter());
        $books = $this->bookRepository->all(
            $request->offset(),
            $request->limit(),
            $request->filter()
        );

        array_walk($books, function (&$book) {
            $book = [
                'id' => $book->bookId()->value(),
                'title' => $book->bookTitle()->value(),
                'genres' => array_map(function ($genre) {
                    return [
                        'id' => $genre->genreId()->value(),
                        'name' => $genre->genreName()->value(),
                    ];
                }, $book->bookGenres()),
            ];
        });

        return new ListBookResponse($total, $books);
    }
}
