<?php

namespace Bookshop\Catalog\Domain\Book;

class Book
{
    private BookId $id;
    private BookTitle $title;

    public function __construct(BookId $id, BookTitle $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public function id(): BookId
    {
        return $this->id;
    }

    public function title(): BookTitle
    {
        return $this->title;
    }
}