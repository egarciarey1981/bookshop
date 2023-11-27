<?php

namespace Bookshop\Catalog\Application\Service\Genre\View;

final class ViewGenreRequest
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
