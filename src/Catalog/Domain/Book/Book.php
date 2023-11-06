<?php

namespace Bookshop\Catalog\Domain\Book;

use Bookshop\Catalog\Domain\Genre\CollectionGenres;

class Book
{
    private BookId $id;
    private BookTitle $title;
    private CollectionGenres $genres;

    public function __construct(BookId $id, BookTitle $title, CollectionGenres $genres)
    {
        $this->id = $id;
        $this->title = $title;
        $this->genres = $genres;
    }

    public function id(): BookId
    {
        return $this->id;
    }

    public function title(): BookTitle
    {
        return $this->title;
    }

    public function genres(): CollectionGenres
    {
        return $this->genres;
    }
}