<?php

namespace Test\Unit\Bookshop\Catalog\Application\Service\Genre;

use Bookshop\Catalog\Application\Service\Genre\Remove\RemoveGenreRequest;
use Bookshop\Catalog\Application\Service\Genre\Remove\RemoveGenreService;
use Bookshop\Catalog\Domain\Model\Genre\GenreDoesNotExistException;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use PHPUnit\Framework\TestCase;
use Tests\Utils\Bookshop\Catalog\Model\Domain\Genre\GenreObjectMother;

class RemoveGenreServiceTest extends TestCase
{
    public function testRemoveGenreDoesNotExist(): void
    {
        $repository = $this->createMock(GenreRepository::class);
        $repository
            ->expects($this->once())
            ->method('ofGenreId')
            ->willReturn(null);

        $service = new RemoveGenreService($repository);
        $request = new RemoveGenreRequest('invalid-id');

        $this->expectException(GenreDoesNotExistException::class);
        $service->execute($request);
    }

    public function testRemoveGenre(): void
    {
        $genre = GenreObjectMother::createOne();

        $repository = $this->createMock(GenreRepository::class);
        $repository
            ->expects($this->once())
            ->method('ofGenreId')
            ->with($genre->genreId())
            ->willReturn($genre);

        $repository
            ->expects($this->once())
            ->method('remove')
            ->with($genre);

        $service = new RemoveGenreService($repository);
        $request = new RemoveGenreRequest($genre->genreId()->value());
        $service->execute($request);
    }
}
