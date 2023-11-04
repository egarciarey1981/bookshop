<?php

namespace Bookshop\Catalog\Application\Genre\Update;

use Bookshop\Catalog\Domain\Genre\GenreId;
use Bookshop\Catalog\Domain\Genre\GenreName;

class UpdateGenreRequest
{
    private GenreId $genreId;
    private GenreName $genreName;

    public function __construct(
        string $id,
        string $name,
    )
    {
        $this->genreId = new GenreId($id);
        $this->genreName = new GenreName($name);
    }

    public function genreId(): GenreId
    {
        return $this->genreId;
    }

    public function genreName(): GenreName
    {
        return $this->genreName;
    }
}
