<?php

namespace Bookshop\Catalog\Application\Book\View;

use Bookshop\Catalog\Domain\Book\Book;
use Bookshop\Catalog\Domain\Genre\Genre;

class ViewBookResponse
{
    private array $book = [];

    public function __construct(Book $book, Genre ...$genres)
    {
        $this->book = [
            'id' => $book->id()->value(),
            'title' => $book->title()->value(),
        ];
        $this->book['genres'] = array_map(
            fn ($genre) => [
                'id' => $genre->id()->value(),
                'name' => $genre->name()->value(),
            ],
            $genres,
        );
    }

    public function book(): array
    {
        return $this->book;
    }
}
