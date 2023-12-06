<?php

namespace Bookshop\Catalog\Application\Service\Genre\View;

final class ViewGenreResponse
{
    private string $id;
    private string $name;
    private int $numberOfBooks;

    public function __construct(string $id, string $name, int $numberOfBooks)
    {
        $this->id = $id;
        $this->name = $name;
        $this->numberOfBooks = $numberOfBooks;
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
        return $this->numberOfBooks;
    }
}
