<?php

namespace Bookshop\Catalog\Application\Service\Book\List;

use Bookshop\Catalog\Application\Service\Book\List\ListBookRequest;
use Bookshop\Catalog\Application\Service\Book\List\ListBookResponse;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;

class ListBookService
{
    private BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function execute(ListBookRequest $request): ListBookResponse
    {
        $total = $this->bookRepository->count($request->filter());
        $bookCollection = $this->bookRepository->all(
            $request->offset(),
            $request->limit(),
            $request->filter()
        );

        return new ListBookResponse(
            $total,
            $bookCollection->toArray()
        );
    }
}
