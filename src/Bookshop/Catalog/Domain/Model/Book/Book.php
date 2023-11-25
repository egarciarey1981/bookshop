<?php

namespace Bookshop\Catalog\Domain\Model\Book;

use Bookshop\Catalog\Domain\Model\Genre\Genre;

class Book
{
    /** @param array<Genre> $bookGenres */
    public function __construct(
        private BookId $bookId,
        private BookTitle $bookTitle,
        private array $bookGenres,
    ) {
    }

    public function bookId(): BookId
    {
        return $this->bookId;
    }

    public function bookTitle(): BookTitle
    {
        return $this->bookTitle;
    }

    /** @return array<Genre> */
    public function bookGenres(): array
    {
        return $this->bookGenres;
    }

    /** @return array<string,string|array<array<string,int|string>>> */
    public function toArray(): array
    {
        return [
            'id' => $this->bookId->value(),
            'title' => $this->bookTitle->value(),
            'genres' => array_map(
                fn (Genre $genre) => $genre->toArray(),
                $this->bookGenres
            ),
        ];
    }
}
