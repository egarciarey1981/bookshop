<?php

namespace Test\Integration\Bookshop\Catalog\Infrastructure\Persistence\Pdo;

use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Bookshop\Catalog\Infrastructure\Persistence\Pdo\PdoGenreRepository;
use PDO;
use Tests\Utils\Bookshop\Catalog\Model\Domain\Genre\GenreObjectMother;
use Tests\Utils\MyTestCase;

class PdoGenreRepositoryTest extends MyTestCase
{
    private PdoGenreRepository $genreRepository;
    protected function setUp(): void
    {
        parent::setUp();
        $pdo = $this->getAppInstance()->getContainer()->get(PDO::class);
        $this->genreRepository = new PdoGenreRepository($pdo);
    }

    public function testInsert(): void
    {
        $genreObjectMother = GenreObjectMother::createOne();
        $this->genreRepository->insert($genreObjectMother);

        $genre = $this->genreRepository->ofGenreId($genreObjectMother->genreId());
        $this->assertInstanceOf(Genre::class, $genre);
        $this->assertTrue($genreObjectMother->genreId()->equals($genre->genreId()));
        $this->assertTrue($genreObjectMother->genreName()->equals($genre->genreName()));
        $this->assertTrue($genreObjectMother->genreNumberOfBooks()->equals($genre->genreNumberOfBooks()));
    }
}
