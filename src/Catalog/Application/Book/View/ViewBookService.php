<?php

namespace Bookshop\Catalog\Application\Book\View;

use Bookshop\Catalog\Domain\Book\BookDoesNotExistException;
use Bookshop\Catalog\Domain\Book\BookRepository;

class ViewBookService
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }
    
    public function __invoke(ViewBookRequest $request): ViewBookResponse
    {
        $book = $this->bookRepository->ofBookId(
            $request->bookId(),
        );

        if ($book === null) {
            throw new BookDoesNotExistException(
                $request->bookId(),
            );
        }

        $data['book'] = [
            'id' => $book->id()->value(),
            'title' => $book->title()->value(),
            'genres' => array_map(function ($genre) {
                return [
                    'id' => $genre->id()->value(),
                    'name' => $genre->name()->value(),
                ];
            }, $book->genres()->genres()),
        ];

        return new ViewBookResponse($data);
    }

}