<?php

namespace Bookshop\Catalog\Application\Service\Genre\List;

final class ListGenreResponse
{
    private int $total;
    private array $genres;

    public function __construct(int $total, array $genres)
    {
        $this->total = $total;
        $this->genres = $genres;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function genres(): array
    {
        return $this->genres;
    }
}
