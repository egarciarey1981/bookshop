<?php

namespace Bookshop\Catalog\Application\Service\Genre\Create;

class CreateGenreRequest
{
    private string $genreName;

    public function __construct(string $genreName)
    {
        $this->genreName = $genreName;
    }

    public function genreName(): string
    {
        return $this->genreName;
    }
}