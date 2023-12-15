<?php

namespace Test\Unit\Bookshop\Catalog\Application\Service\Genre;

use Bookshop\Catalog\Application\Service\Genre\Create\CreateGenreRequest;
use Bookshop\Catalog\Application\Service\Genre\Create\CreateGenreService;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use PHPUnit\Framework\TestCase;

class CreateGenreServiceTest extends TestCase
{
    public function testCreateGenre(): void
    {
        $repository = $this->createMock(GenreRepository::class);
        $repository
            ->expects($this->once())
            ->method('insert');

        $service = new CreateGenreService($repository);
        $request = new CreateGenreRequest('Science Fiction');

        $request = $service->execute($request);
        $this->assertNotNull($request->id());
    }
}
