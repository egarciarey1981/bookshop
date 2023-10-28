<?php

namespace Bookshop\Catalog\Domain\Book;

interface BookRepository
{
    public function all(int $offset, int $limit): array;
    public function ofId(BookId $id): Book;
    public function insert(Book $book): void;
    public function update(Book $book): void;
    public function delete(BookId $bookId): void;
    public function nextIdentity(): BookId;
}
