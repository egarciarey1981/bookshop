<?php

namespace Test\Integration\Bookshop\Catalog\Infrastructure\Persistence\Pdo;

use Bookshop\Catalog\Infrastructure\Persistence\Pdo\PdoGenreRepository;
use PDO;
use PHPUnit\Framework\TestCase;
use Tests\Utils\Bookshop\Catalog\Model\Domain\Genre\GenreObjectMother;

class PdoGenreRepositoryTest extends TestCase
{
    private PDO $pdo;

    public function setUp(): void
    {
        $driver = 'mysql';
        $dbname = 'bookshop';
        $host = 'mysql_test';
        $user = 'root';
        $pass = 'root';

        $this->pdo = new PDO("$driver:host=$host;dbname=$dbname", $user, $pass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function testInsert(): void
    {
        $genreObjectMother = GenreObjectMother::createOne();
        $genreRepository = new PdoGenreRepository($this->pdo);
        $genreRepository->insert($genreObjectMother);

        $genre = $genreRepository->ofGenreId($genreObjectMother->genreId());
        $this->assertEquals($genreObjectMother, $genre);
    }
}
