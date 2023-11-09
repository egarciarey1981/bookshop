<?php

namespace Bookshop\Catalog\Domain\Genre;

class Genre
{
    private GenreId $id;
    private GenreName $name;

    public function __construct(GenreId $id, GenreName $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function id(): GenreId
    {
        return $this->id;
    }

    public function name(): GenreName
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name->value(),
        ];
    }
}
