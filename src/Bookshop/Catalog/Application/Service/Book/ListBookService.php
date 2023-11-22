<?php

namespace Bookshop\Catalog\Application\Service\Book;

use Bookshop\Catalog\Application\Service\Book\BookService;

class ListBookService extends BookService
{
    public function execute(int $offset, int $limit, string $filter): array
    {
        $books = $this->bookRepository->all($offset, $limit, $filter);
        $total = $this->bookRepository->count($filter);

        array_walk($books, function (&$book) {
            $book = $book->toArray();
        });

        return [
            'books' => $books,
            'total' => $total,
        ];
    }
}
