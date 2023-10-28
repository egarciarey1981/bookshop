<?php

namespace Bookshop\Catalog\Application\Book\Create;

use Bookshop\Catalog\Domain\Book\Book;

class CreateBookResponse
{
    private array $book = [];

    public function __construct(Book $book)
    {
        $this->book = [
            'id' => $book->id()->value(),
            'title' => $book->title()->value(),
        ];
    }

    public function book(): array
    {
        return $this->book;
    }
}
