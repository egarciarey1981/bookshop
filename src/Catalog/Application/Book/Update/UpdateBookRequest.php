<?php

namespace Bookshop\Catalog\Application\Book\Update;

class UpdateBookRequest
{
    private string $bookId;
    private string $bookTitle;
    private array $bookGenreIds;

    public function __construct(
        string $bookId,
        string $bookTitle,
        array $bookGenreIds
    ) {
        $this->bookId = $bookId;
        $this->bookTitle = $bookTitle;
        $this->bookGenreIds = $bookGenreIds;
    }

    public function bookId(): string
    {
        return $this->bookId;
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
