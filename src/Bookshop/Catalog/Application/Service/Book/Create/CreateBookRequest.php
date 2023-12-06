<?php

namespace Bookshop\Catalog\Application\Service\Book\Create;

class CreateBookRequest
{
    private string $title;
    private array $genreIds;

    public function __construct(string $title, array $genreIds)
    {
        $this->title = $title;
        $this->genreIds = $genreIds;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function genreIds(): array
    {
        return $this->genreIds;
    }
}
