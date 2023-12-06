<?php

namespace Bookshop\Catalog\Domain\Model\Book;

class Book
{
    private BookId $bookId;
    private BookTitle $bookTitle;
    private array $bookGenres;

    public function __construct(
        BookId $bookId,
        BookTitle $bookTitle,
        array $bookGenres,
    ) {
        $this->bookId = $bookId;
        $this->bookTitle = $bookTitle;
        $this->bookGenres = $bookGenres;
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
