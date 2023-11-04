<?php

namespace Bookshop\Catalog\Application\Genre\Remove;

use Bookshop\Catalog\Domain\Genre\GenreId;

class RemoveGenreRequest
{
    private GenreId $genreId;

    public function __construct(string $id)
    {
        $this->genreId = new GenreId($id);
    }

    public function genreId(): GenreId
    {
        return $this->genreId;
    }
}
