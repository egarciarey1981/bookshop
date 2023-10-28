<?php

namespace Bookshop\Catalog\Infrastructure\Persistence\InMemory;

use Bookshop\Catalog\Domain\Book\Book;
use Bookshop\Catalog\Domain\Book\BookId;
use Bookshop\Catalog\Domain\Book\BookTitle;
use Bookshop\Catalog\Domain\Book\BookRepository;
use Bookshop\Catalog\Domain\Book\BookDoesNotExistException;

class InMemoryBookRepository implements BookRepository
{
    private $books = [];

    public function __construct()
    {
        $this->books = [
            ['id' => 'book-01', 'name' => 'Title Book 01'],
            ['id' => 'book-02', 'name' => 'Title Book 02'],
            ['id' => 'book-03', 'name' => 'Title Book 03'],
            ['id' => 'book-04', 'name' => 'Title Book 04'],
            ['id' => 'book-05', 'name' => 'Title Book 05'],
            ['id' => 'book-06', 'name' => 'Title Book 06'],
            ['id' => 'book-07', 'name' => 'Title Book 07'],
            ['id' => 'book-08', 'name' => 'Title Book 08'],
            ['id' => 'book-09', 'name' => 'Title Book 09'],
            ['id' => 'book-10', 'name' => 'Title Book 10'],
            ['id' => 'book-11', 'name' => 'Title Book 11'],
            ['id' => 'book-12', 'name' => 'Title Book 12'],
            ['id' => 'book-13', 'name' => 'Title Book 13'],
            ['id' => 'book-14', 'name' => 'Title Book 14'],
            ['id' => 'book-15', 'name' => 'Title Book 15'],
            ['id' => 'book-16', 'name' => 'Title Book 16'],
            ['id' => 'book-17', 'name' => 'Title Book 17'],
            ['id' => 'book-18', 'name' => 'Title Book 18'],
            ['id' => 'book-19', 'name' => 'Title Book 19'],
            ['id' => 'book-20', 'name' => 'Title Book 20'],
            ['id' => 'book-21', 'name' => 'Title Book 21'],
            ['id' => 'book-22', 'name' => 'Title Book 22'],
            ['id' => 'book-23', 'name' => 'Title Book 23'],
            ['id' => 'book-24', 'name' => 'Title Book 24'],
            ['id' => 'book-25', 'name' => 'Title Book 25'],
        ];
    }

    public function all(int $offset, int $limit): array
    {
        $result = [];

        foreach (array_slice($this->books, $offset, $limit) as $book) {
            $result[] = new Book(
                new BookId($book['id']),
                new BookTitle($book['name'])
            );
        }
        return $result;
    }

    public function ofId(BookId $bookId): Book
    {
        foreach ($this->books as $book) {
            if ($book['id'] === $bookId->value()) {
                return new Book(
                    new BookId($book['id']),
                    new BookTitle($book['name'])
                );
            }
        }

        throw new BookDoesNotExistException($bookId);
    }

    public function insert(Book $book): void
    {
        $this->books[] = [
            'id' => $book->id()->value(),
            'name' => $book->title()->value(),
        ];
    }

    public function update(Book $book): void
    {
        foreach ($this->books as &$bookInMemory) {
            if ($bookInMemory['id'] === $book->id()->value()) {
                $bookInMemory['name'] = $book->title()->value();
                return;
            }
        }

        throw new BookDoesNotExistException($book->id());
    }

    public function delete(BookId $bookId): void
    {
        foreach ($this->books as $key => $book) {
            if ($book['id'] === $bookId->value()) {
                unset($this->books[$key]);
                return;
            }
        }

        throw new BookDoesNotExistException($bookId);
    }

    public function nextIdentity(): BookId
    {
        return new BookId('book-' . (count($this->books) + 1));
    }
}