<?php

namespace Bookshop\Catalog\Application\Service\Genre\View;

final class ViewGenreResponse
{
    /** @var array<string,string|int> $genre */
    private array $genre;

    /** @param array<string,string|int> $genre */
    public function __construct(array $genre)
    {
        $this->genre = $genre;
    }

    /** @return array<string,string|int> */
    public function genre(): array
    {
        return $this->genre;
    }
}
