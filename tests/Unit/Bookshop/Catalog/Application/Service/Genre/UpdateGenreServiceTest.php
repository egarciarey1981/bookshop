<?php

namespace Test\Unit\Bookshop\Catalog\Application\Service\Genre;

use Bookshop\Catalog\Application\Service\Genre\Update\UpdateGenreRequest;
use Bookshop\Catalog\Application\Service\Genre\Update\UpdateGenreService;
use Bookshop\Catalog\Domain\Exception\DomainException;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use PHPUnit\Framework\TestCase;
use Tests\Utils\Bookshop\Catalog\Model\Domain\Genre\GenreObjectMother;

class UpdateGenreServiceTest extends TestCase
{
    /**
     * @dataProvider correctData
     */
    public function testUpdateGenre(string $id, string $name): void
    {
        $repository = $this->createMock(GenreRepository::class);
        $repository
            ->expects($this->once())
            ->method('ofGenreId')
            ->willReturn(GenreObjectMother::createOne());
        $repository
            ->expects($this->once())
            ->method('update');

        $service = new UpdateGenreService($repository);
        $request = new UpdateGenreRequest($id, $name);
        $service->execute($request);
    }

    /**
     * @dataProvider wrongData
     */
    public function testGivenWrongDataWhenUpdateGenreThenThrowException(string $id, string $name): void
    {
        $this->expectException(DomainException::class);

        $repository = $this->createMock(GenreRepository::class);

        $service = new UpdateGenreService($repository);
        $request = new UpdateGenreRequest($id, $name);
        $service->execute($request);
    }

    public function testGenreDoesNotExist(): void
    {
        $this->expectException(DomainException::class);

        $repository = $this->createMock(GenreRepository::class);
        $repository
            ->expects($this->once())
            ->method('ofGenreId')
            ->willReturn(null);

        $service = new UpdateGenreService($repository);
        $request = new UpdateGenreRequest('foo', 'bar');
        $service->execute($request);
    }

    public static function wrongData(): array
    {
        return [
            ['', 'foo'],
        ];
    }

    public static function correctData(): array
    {
        return [
            [
                'id' => 'foo',
                'name' => 'bar',
            ],
        ];
    }
}
