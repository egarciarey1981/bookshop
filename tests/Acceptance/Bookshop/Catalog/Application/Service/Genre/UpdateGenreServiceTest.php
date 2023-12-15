<?php

namespace Test\Acceptance\Bookshop\Catalog\Application\Service\Genre;

use Bookshop\Catalog\Application\Service\Genre\Update\UpdateGenreRequest;
use Bookshop\Catalog\Application\Service\Genre\Update\UpdateGenreService;
use Bookshop\Catalog\Domain\Model\Genre\GenreDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use Tests\Utils\Bookshop\Catalog\Model\Domain\Genre\GenreObjectMother;
use Tests\Utils\MyTestCase;

class UpdateGenreServiceTest extends MyTestCase
{
    private UpdateGenreService $createGenreService;
    private GenreRepository $genreRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createGenreService = $this->getAppInstance()->getContainer()->get(UpdateGenreService::class);
        $this->genreRepository = $this->getAppInstance()->getContainer()->get(GenreRepository::class);
    }

    public function testUpdateGenre(): void
    {
        $genreInserted = GenreObjectMother::createOne();
        $this->genreRepository->insert($genreInserted);

        $request = new UpdateGenreRequest($genreInserted->genreId()->value(), 'Name updated');
        $this->createGenreService->execute($request);

        $genreUpdated = $this->genreRepository->ofGenreId($genreInserted->genreId());
        $this->assertNotNull($genreUpdated);
        $this->assertEquals('Name updated', $genreUpdated->genreName()->value());
    }

    public function testUpdateGenreDoesNotExist(): void
    {
        $this->expectException(GenreDoesNotExistException::class);
        $request = new UpdateGenreRequest('invalid-id', 'Name updated');
        $this->createGenreService->execute($request);
    }
}
