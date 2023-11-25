<?php

namespace Bookshop\Catalog\Application\Service\Book\View;

final class ViewBookRequest
{
    private string $bookId;

    public function __construct(string $bookId)
    {
        $this->bookId = $bookId;
    }

    public function bookId(): string
    {
        return $this->bookId;
    }
}
