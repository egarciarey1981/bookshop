<?php

namespace Bookshop\Catalog\Application\Book\List;

use Bookshop\Catalog\Domain\Book\Book;

class ListBooksResponse
{
    private array $books = [];

    public function __construct(Book ...$books)
    {
        foreach ($books as $book) {
            $this->books[] = [
                'id' => $book->id()->value(),
                'title' => $book->title()->value(),
            ];
        }
    }

    public function books(): array
    {
        return $this->books;
    }
}