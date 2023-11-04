<?php

namespace Bookshop\Catalog\Application\Genre\Create;

use Bookshop\Catalog\Domain\Genre\GenreName;

class CreateGenreRequest
{
    private GenreName $genreName;

    public function __construct(string $name)
    {
        $this->genreName = new GenreName($name);
    }

    public function genreName(): GenreName
    {
        return $this->genreName;
    }
}
