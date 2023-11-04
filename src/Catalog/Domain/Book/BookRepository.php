<?php

namespace Bookshop\Catalog\Domain\Book;

interface BookRepository
{
    public function nextIdentity(): BookId;
    public function all(int $offset, int $limit): array;
    public function bookOfId(BookId $id): ?Book;
    public function save(Book $book): void;
    public function remove(Book $book): void;
}
