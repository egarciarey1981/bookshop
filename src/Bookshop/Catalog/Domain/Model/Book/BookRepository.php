<?php

namespace Bookshop\Catalog\Domain\Model\Book;

interface BookRepository
{
    public function nextIdentity(): BookId;
    public function all(int $offset, int $limit, string $filter): BookCollection;
    public function count(string $filter): int;
    public function ofBookId(BookId $bookId): Book;
    public function insert(Book $book): void;
    public function update(Book $book): void;
    public function remove(Book $book): void;
}
