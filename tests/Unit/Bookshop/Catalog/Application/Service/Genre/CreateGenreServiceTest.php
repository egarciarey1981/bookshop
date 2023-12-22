<?php

namespace Test\Unit\Bookshop\Catalog\Application\Service\Genre;

use Bookshop\Catalog\Application\Service\Genre\Create\CreateGenreRequest;
use Bookshop\Catalog\Application\Service\Genre\Create\CreateGenreService;
use Bookshop\Catalog\Domain\Exception\DomainException;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use PHPUnit\Framework\TestCase;

class CreateGenreServiceTest extends TestCase
{
    /**
     * @dataProvider correctData
     */
    public function testCreateGenre(string $name): void
    {
        $repository = $this->createMock(GenreRepository::class);
        $repository
            ->expects($this->once())
            ->method('insert');

        $service = new CreateGenreService($repository);
        $request = new CreateGenreRequest($name);

        $response = $service->execute($request);
        $this->assertNotNull($response->id());
    }

    /**
     * @dataProvider wrongData
     */
    public function testGivenWrongDataWhenCreateGenreThenThrowException(string $name): void
    {
        $repository = $this->createMock(GenreRepository::class);
        $service = new CreateGenreService($repository);
        $request = new CreateGenreRequest($name);

        $this->expectException(DomainException::class);
        $service->execute($request);
    }

    public static function correctData(): array
    {
        return [
            ['aaa'],
            [str_repeat('a', 255)],
        ];
    }

    public static function wrongData(): array
    {
        return [
            [''],
            ['aa'],
            [str_repeat('a', 256)],
        ];
    }
}
