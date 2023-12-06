<?php

namespace Bookshop\Catalog\Application\Service\Book\View;

class ViewBookResponse
{
    private string $id;
    private string $title;
    private array $bookGenres;

    public function __construct(
        string $id,
        string $title,
        array $bookGenres,
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->bookGenres = $bookGenres;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function bookGenres(): array
    {
        return $this->bookGenres;
    }
}
