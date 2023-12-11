<?php

namespace Bookshop\Catalog\Application\Service\Genre\View;

class ViewGenreResponse
{
    private string $id;
    private string $name;
    private int $genreNumberOfBooks;

    public function __construct(string $id, string $name, int $genreNumberOfBooks)
    {
        $this->id = $id;
        $this->name = $name;
        $this->genreNumberOfBooks = $genreNumberOfBooks;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function numberOfBooks(): int
    {
        return $this->genreNumberOfBooks;
    }
}
