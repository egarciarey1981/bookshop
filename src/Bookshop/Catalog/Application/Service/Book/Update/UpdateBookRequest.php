<?php

namespace Bookshop\Catalog\Application\Service\Book\Update;

final class UpdateBookRequest
{
    private string $bookId;
    private string $bookTitle;
    /** @var array<string> */
    private array $bookGenres;

    /** @param array<string> $bookGenres */
    public function __construct(
        string $bookId,
        string $bookTitle,
        array $bookGenres,
    ) {
        $this->bookId = $bookId;
        $this->bookTitle = $bookTitle;
        $this->bookGenres = $bookGenres;
    }

    public function bookId(): string
    {
        return $this->bookId;
    }

    public function bookTitle(): string
    {
        return $this->bookTitle;
    }

    /** @return array<string> */
    public function bookGenres(): array
    {
        return $this->bookGenres;
    }
}
