<?php

namespace Bookshop\Catalog\Domain\Model\Genre;

use ArrayIterator;
use Bookshop\Catalog\Domain\Model\Genre\Genre;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<Genre>
 */
class GenreCollection implements IteratorAggregate
{
    /**
     * @var Genre[]
     * */
    private array $genres;

    public function __construct(Genre ...$genres)
    {
        $this->genres = $genres;
    }

    public function add(Genre $genre): void
    {
        $this->genres[] = $genre;
    }

    /**
     * @return array<array<string, string|int>>
     */
    public function toArray(): array
    {
        return array_map(
            fn (Genre $genre) => $genre->toArray(),
            $this->genres
        );
    }

    /**
     * @return ArrayIterator<string,Genre>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->genres);
    }
}
