<?php

namespace Bookshop\Catalog\Application\Service\Genre\Create;

final class CreateGenreResponse
{
    /** @var array<string,string|int> */
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
