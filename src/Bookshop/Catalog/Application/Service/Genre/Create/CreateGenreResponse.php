<?php

namespace Bookshop\Catalog\Application\Service\Genre\Create;

class CreateGenreResponse
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
