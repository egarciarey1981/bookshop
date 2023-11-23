<?php

namespace Bookshop\Catalog\Domain\Model\Book;

interface BookRepository
{
    public function nextIdentity(): BookId;
    /** @return array<Book> */
    public function all(int $offset, int $limit, string $filter): array;
    public function count(string $filter): int;
    public function ofBookId(BookId $bookId): ?Book;
    public function insert(Book $book): bool;
    public function update(Book $book): bool;
    public function remove(Book $book): bool;
}
