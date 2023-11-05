<?php

namespace Bookshop\Catalog\Infrastructure\Persistence\Pdo;

use PDO;
use Bookshop\Catalog\Domain\Book\BookId;
use Bookshop\Catalog\Domain\BookGenre\BookGenre;
use Bookshop\Catalog\Domain\BookGenre\BookGenreRepository;
use Bookshop\Catalog\Domain\Genre\GenreId;

class PdoBookGenreRepository extends PdoRepository implements BookGenreRepository
{
    public function ofBookId(BookId $bookId): array
    {
        $sql = "SELECT * FROM books_genres WHERE book_id = :book_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('book_id', $bookId->value(), PDO::PARAM_STR);
        $stmt->execute();

        $booksGenres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(
            fn ($bookGenre) => new BookGenre(
                new BookId($bookGenre['book_id']),
                new GenreId($bookGenre['genre_id']),
            ),
            $booksGenres,
        );
    }

    public function ofBookIds(array $bookIds): array
    {
        $arrayIds = array_map(
            fn ($bookId) => $bookId->value(),
            $bookIds,
        );
        $listIds = implode(',', array_fill(0, count($arrayIds), '?'));

        $sql = "SELECT * FROM books_genres WHERE book_id IN ($listIds)";
        $stmt = $this->connection->prepare($sql);
        foreach ($arrayIds as $k => $id) {
            $stmt->bindValue($k + 1, $id, PDO::PARAM_STR);
        }
        $stmt->execute();

        $booksGenres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(
            fn ($bookGenre) => new BookGenre(
                new BookId($bookGenre['book_id']),
                new GenreId($bookGenre['genre_id']),
            ),
            $booksGenres,
        );
    }
}