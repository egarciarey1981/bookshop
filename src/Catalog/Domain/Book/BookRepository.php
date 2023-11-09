<?php

namespace Bookshop\Catalog\Domain\Book;

interface BookRepository
{
    public function nextIdentity(): BookId;
    public function all(int $offset, int $limit, string $filter): array;
    public function count(string $filter): int;
    public function ofBookId(BookId $bookId): ?Book;
    public function save(Book $book): void;
    public function remove(Book $book): void;
}
