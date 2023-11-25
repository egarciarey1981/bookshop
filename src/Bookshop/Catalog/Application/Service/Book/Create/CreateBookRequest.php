<?php

namespace Bookshop\Catalog\Application\Service\Book\Create;

final class CreateBookRequest
{
    private string $bookTitle;
    /** @var array<string> */
    private array $bookGenres;

    /** @param array<string> $bookGenres */
    public function __construct(string $bookTitle, array $bookGenres)
    {
        $this->bookTitle = $bookTitle;
        $this->bookGenres = $bookGenres;
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
