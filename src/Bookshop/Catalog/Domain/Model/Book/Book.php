<?php

namespace Bookshop\Catalog\Domain\Model\Book;

use Bookshop\Catalog\Domain\Model\Genre\GenreCollection;

class Book
{
    public function __construct(
        private BookId $bookId,
        private BookTitle $bookTitle,
        private GenreCollection $bookGenres,
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

    public function bookGenres(): GenreCollection
    {
        return $this->bookGenres;
    }

    /** @return array<string,string|array<array<string,int|string>>> */
    public function toArray(): array
    {
        return [
            'id' => $this->bookId->value(),
            'title' => $this->bookTitle->value(),
            'genres' => $this->bookGenres->toArray(),
        ];
    }
}
