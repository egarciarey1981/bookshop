<?php

namespace Test\Unit\Bookshop\Catalog\Application\Service\Genre;

use Bookshop\Catalog\Application\Service\Genre\View\ViewGenreRequest;
use Bookshop\Catalog\Application\Service\Genre\View\ViewGenreService;
use Bookshop\Catalog\Domain\Exception\DomainException;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use PHPUnit\Framework\TestCase;
use Tests\Utils\Bookshop\Catalog\Model\Domain\Genre\GenreObjectMother;

class ViewGenreServiceTest extends TestCase
{
    public function testUpdateGenre(): void
    {
        $genreObjectMother = GenreObjectMother::createOne();

        $repository = $this->createMock(GenreRepository::class);
        $repository
            ->expects($this->once())
            ->method('ofGenreId')
            ->willReturn($genreObjectMother);

        $service = new ViewGenreService($repository);
        $request = new ViewGenreRequest($genreObjectMother->genreId()->value());
        $response = $service->execute($request);

        $this->assertEquals($genreObjectMother->genreId()->value(), $response->id());
        $this->assertEquals($genreObjectMother->genreName()->value(), $response->name());
        $this->assertEquals($genreObjectMother->genreNumberOfBooks()->value(), $response->numberOfBooks());
    }

    public function testGenreDoesNotExist(): void
    {
        $this->expectException(DomainException::class);

        $repository = $this->createMock(GenreRepository::class);
        $repository
            ->expects($this->once())
            ->method('ofGenreId')
            ->willReturn(null);

        $service = new ViewGenreService($repository);
        $request = new ViewGenreRequest('foo');
        $service->execute($request);
    }
}
