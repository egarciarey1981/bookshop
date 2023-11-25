<?php

namespace Bookshop\Catalog\Domain\Model\Book;

use ArrayIterator;
use Bookshop\Catalog\Domain\Model\Book\Book;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<Book>
 */
class BookCollection implements IteratorAggregate
{
    /**
     * @var Book[]
     * */
    private array $books;

    public function __construct(Book ...$books)
    {
        $this->books = $books;
    }

    public function add(Book $book): void
    {
        $this->books[] = $book;
    }

    /**
     * @return array<array<string,array<array<string,int|string>>|string>>
     */
    public function toArray(): array
    {
        return array_map(
            fn (Book $book) => $book->toArray(),
            $this->books
        );
    }

    /**
     * @return ArrayIterator<string,Book>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->books);
    }
}
