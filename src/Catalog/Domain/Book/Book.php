<?php

namespace Bookshop\Catalog\Domain\Book;

use Bookshop\Catalog\Domain\Genre\GenresCollection;

class Book
{
    private BookId $id;
    private BookTitle $title;
    private GenresCollection $genres;

    public function __construct(BookId $id, BookTitle $title, GenresCollection $genres)
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

    public function genres(): GenresCollection
    {
        return $this->genres;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'title' => $this->title->value(),
            'genres' => $this->genres->toArray(),
        ];
    }
}