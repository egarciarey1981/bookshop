<?php

namespace Test\Acceptance\Bookshop\Catalog\Application\Service\Genre;

use Bookshop\Catalog\Application\Service\Genre\Create\CreateGenreRequest;
use Bookshop\Catalog\Application\Service\Genre\Create\CreateGenreService;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use Tests\Utils\MyTestCase;

class CreateGenreServiceTest extends MyTestCase
{
    private CreateGenreService $createGenreService;
    private GenreRepository $genreRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createGenreService = $this->getAppInstance()->getContainer()->get(CreateGenreService::class);
        $this->genreRepository = $this->getAppInstance()->getContainer()->get(GenreRepository::class);
    }

    public function testCreateGenre(): void
    {
        $request = new CreateGenreRequest('Fantasy');
        $response = $this->createGenreService->execute($request);

        $genreId = new GenreId($response->id());
        $genre = $this->genreRepository->ofGenreId($genreId);

        $this->assertNotNull($genre);
        $this->assertEquals('Fantasy', $genre->genreName()->value());
    }
}
