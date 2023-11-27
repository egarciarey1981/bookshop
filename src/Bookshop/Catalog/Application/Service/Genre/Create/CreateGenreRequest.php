<?php

namespace Bookshop\Catalog\Application\Service\Genre\Create;

final class CreateGenreRequest
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}
