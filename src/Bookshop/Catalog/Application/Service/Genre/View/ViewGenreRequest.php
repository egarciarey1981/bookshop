<?php

namespace Bookshop\Catalog\Application\Service\Genre\View;

final class ViewGenreRequest
{
    private string $genreId;

    public function __construct(string $genreId)
    {
        $this->genreId = $genreId;
    }

    public function genreId(): string
    {
        return $this->genreId;
    }
}
