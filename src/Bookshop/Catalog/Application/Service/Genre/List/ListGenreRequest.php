<?php

namespace Bookshop\Catalog\Application\Service\Genre\List;

class ListGenreRequest
{
    private int $offset;
    private int $limit;
    private string $filter;

    public function __construct(int $offset, int $limit, string $filter)
    {
        $this->offset = $offset;
        $this->limit = $limit;
        $this->filter = $filter;
    }

    public function offset(): int
    {
        return $this->offset;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function filter(): string
    {
        return $this->filter;
    }
}
