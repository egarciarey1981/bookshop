<?php

namespace Bookshop\Catalog\Domain\Model\Book;

class Book
{
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

    public function bookGenres(): array
    {
        return $this->bookGenres;
    }
}
