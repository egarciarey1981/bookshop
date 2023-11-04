<?php

namespace Bookshop\Catalog\Application\Genre\View;

use Bookshop\Catalog\Domain\Genre\GenreId;

class ViewGenreRequest
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
