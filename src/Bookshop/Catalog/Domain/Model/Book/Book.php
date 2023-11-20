<?php

namespace Bookshop\Catalog\Domain\Model\Book;

use Bookshop\Catalog\Domain\Model\Genre\GenresCollection;

class Book
{
    private BookId $bookId;
    private BookTitle $bookTitle;
    private GenresCollection $bookGenres;

    public function __construct(BookId $bookId, BookTitle $bookTitle, GenresCollection $bookGenres)
    {
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

    public function bookGenres(): GenresCollection
    {
        return $this->bookGenres;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->bookId->value(),
            'title' => $this->bookTitle->value(),
            'genres' => $this->bookGenres->toArray(),
        ];
    }
}
