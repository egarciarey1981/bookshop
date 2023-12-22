<?php

namespace Test\Unit\Bookshop\Catalog\Application\Service\Genre;

use Bookshop\Catalog\Application\Service\Genre\List\ListGenreRequest;
use Bookshop\Catalog\Application\Service\Genre\List\ListGenreService;
use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;
use Bookshop\Catalog\Domain\Model\Genre\GenreNumberOfBooks;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use PHPUnit\Framework\TestCase;
use Tests\Utils\Bookshop\Catalog\Model\Domain\Genre\GenreDataBuilder;
use Tests\Utils\Bookshop\Catalog\Model\Domain\Genre\GenreObjectMother;

class ListGenreServiceTest extends TestCase
{
    /**
     * @dataProvider correctData
     */
    public function testListGenre(int $offset, int $limit, string $filter, $genres): void
    {
        
        $total = 100;

        $repository = $this->createMock(GenreRepository::class);
        $repository
            ->expects($this->once())
            ->method('count')
            ->with($filter)
            ->willReturn($total);

        $repository
            ->expects($this->once())
            ->method('all')
            ->with($offset, $limit, $filter)
            ->willReturn($genres);

        $service = new ListGenreService($repository);
        $request = new ListGenreRequest($offset, $limit, $filter);
        $response = $service->execute($request);

        $this->assertEquals($total, $response->total());
        foreach ($response->genres() as $i => $genre) {
            $this->assertGenre($genre, $genres[$i]);
        }
    }

    private function assertGenre(array $genreArray, Genre $genreObject): void
    {
        $this->assertEquals($genreArray['id'], $genreObject->genreId()->value());
        $this->assertEquals($genreArray['name'], $genreObject->genreName()->value());
        $this->assertEquals($genreArray['number_of_books'], $genreObject->genreNumberOfBooks()->value());
    }

    public static function correctData(): array
    {
        $genreDataBuilder = new GenreDataBuilder();

        return [
            [
                0,
                10,
                '',
                [
                    $genreDataBuilder
                        ->withGenreId(new GenreId('foo'))
                        ->withGenreName(new GenreName('bar'))
                        ->withGenreNumberOfBooks(new GenreNumberOfBooks(10))
                        ->build(),
                    $genreDataBuilder
                        ->withGenreId(new GenreId('foo2'))
                        ->withGenreName(new GenreName('bar2'))
                        ->withGenreNumberOfBooks(new GenreNumberOfBooks(20))
                        ->build(),
                ]
            ],
        ];
    }
}
