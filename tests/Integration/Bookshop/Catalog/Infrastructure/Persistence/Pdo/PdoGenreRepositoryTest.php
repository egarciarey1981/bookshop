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

    public function testInsertOneAndRetrieveIt(): void
    {
        $genreObjectMother = GenreObjectMother::createOne();
        $this->genreRepository->insert($genreObjectMother);

        $genre = $this->genreRepository->ofGenreId($genreObjectMother->genreId());
        $this->assertInstanceOf(Genre::class, $genre);
        $this->assertGenreEquals($genreObjectMother, $genre);
    }

    public function testInsertManyAndRetrieveThem(): void
    {
        $genreObjectMother1 = GenreObjectMother::createOne();
        $genreObjectMother2 = GenreObjectMother::createOne();
        $genreObjectMother3 = GenreObjectMother::createOne();

        $this->genreRepository->insert($genreObjectMother1);
        $this->genreRepository->insert($genreObjectMother2);
        $this->genreRepository->insert($genreObjectMother3);

        $genreIds = [
            $genreObjectMother1->genreId(),
            $genreObjectMother2->genreId(),
            $genreObjectMother3->genreId(),
        ];

        $genres = $this->genreRepository->ofGenreIds(...$genreIds);

        $this->assertCount(3, $genres);

        $this->assertGenreEquals($genreObjectMother1, $genres[0]);
        $this->assertGenreEquals($genreObjectMother2, $genres[1]);
        $this->assertGenreEquals($genreObjectMother3, $genres[2]);
    }

    public function testOfGenreIdsWithEmptyArray(): void
    {
        $genres = $this->genreRepository->ofGenreIds();
        $this->assertEmpty($genres);
    }

    private function assertGenreEquals(Genre $genreA, Genre $genreB): void
    {
        $this->assertEquals(
            $genreA->genreId()->value(),
            $genreB->genreId()->value(),
        );
        $this->assertEquals(
            $genreA->genreName()->value(),
            $genreB->genreName()->value(),
        );
        $this->assertEquals(
            $genreA->genreNumberOfBooks()->value(),
            $genreB->genreNumberOfBooks()->value(),
        );
    }
}
