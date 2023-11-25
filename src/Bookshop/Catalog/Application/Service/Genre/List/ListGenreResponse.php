<?php

namespace Bookshop\Catalog\Application\Service\Genre\List;

final class ListGenreResponse
{
    private int $total;
    /** @var array<array<string,int|string>> */
    private array $genres;

    /** @param array<array<string,int|string>> $genres */
    public function __construct(int $total, array $genres)
    {
        $this->total = $total;
        $this->genres = $genres;
    }

    public function total(): int
    {
        return $this->total;
    }

    /** @return array<array<string,int|string>> */
    public function genres(): array
    {
        return $this->genres;
    }
}
