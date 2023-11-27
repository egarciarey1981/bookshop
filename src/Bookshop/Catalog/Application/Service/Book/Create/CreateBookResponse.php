<?php

namespace Bookshop\Catalog\Application\Service\Book\Create;

final class CreateBookResponse
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
