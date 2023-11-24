<?php

namespace Bookshop\Catalog\Application\Service\Book;

use Bookshop\Catalog\Domain\Model\Book\Book;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;

class ListBookService
{
    public function __construct(
        private readonly BookRepository $bookRepository
    ) {
    }

    /** @return array<string,int|array<array<string|array<array<string,string>>>>> */
    public function execute(int $offset, int $limit, string $filter): array
    {
        $total = $this->bookRepository->count($filter);
        $books = $this->bookRepository->all($offset, $limit, $filter);

        return [
            'total' => $total,
            'books' => array_map(
                fn (Book $book) => $book->toArray(),
                $books
            ),
        ];
    }
}
