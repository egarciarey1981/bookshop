<?php

namespace Test\Acceptance\Bookshop\Catalog\Application\Service\Genre;

use Bookshop\Catalog\Application\Service\Genre\Remove\RemoveGenreRequest;
use Bookshop\Catalog\Application\Service\Genre\Remove\RemoveGenreService;
use Bookshop\Catalog\Domain\Model\Genre\GenreDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use Tests\Utils\Bookshop\Catalog\Model\Domain\Genre\GenreObjectMother;
use Tests\Utils\MyTestCase;

class RemoveGenreServiceTest extends MyTestCase
{
    private RemoveGenreService $createGenreService;
    private GenreRepository $genreRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createGenreService = $this->getAppInstance()->getContainer()->get(RemoveGenreService::class);
        $this->genreRepository = $this->getAppInstance()->getContainer()->get(GenreRepository::class);
    }

    public function testUpdateGenre(): void
    {
        $genreInserted = GenreObjectMother::createOne();
        $this->genreRepository->insert($genreInserted);

        $request = new RemoveGenreRequest($genreInserted->genreId()->value());
        $this->createGenreService->execute($request);

        $genreDeleted = $this->genreRepository->ofGenreId($genreInserted->genreId());
        $this->assertNull($genreDeleted);
    }

    public function testUpdateGenreDoesNotExist(): void
    {
        $this->expectException(GenreDoesNotExistException::class);
        $request = new RemoveGenreRequest('invalid-id');
        $this->createGenreService->execute($request);
    }
}
