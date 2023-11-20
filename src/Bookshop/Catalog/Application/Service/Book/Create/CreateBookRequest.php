<?php

namespace Bookshop\Catalog\Application\Service\Book\Create;

class CreateBookRequest
{
    private string $bookTitle;
    private array $bookGenreIds;

    public function __construct(string $bookTitle, array $bookGenreIds)
    {
        $this->bookTitle = $bookTitle;
        $this->bookGenreIds = $bookGenreIds;
    }

    public function bookTitle(): string
    {
        return $this->bookTitle;
    }

    public function bookGenreIds(): array
    {
        return $this->bookGenreIds;
    }
}
