<?php

declare(strict_types=1);

namespace App\Actions\Book;

use App\Actions\Action;
use Bookshop\Catalog\Domain\Model\Book\BookRepository;
use Psr\Log\LoggerInterface;

abstract class BookAction extends Action
{
    protected BookRepository $bookRepository;

    public function __construct(
        LoggerInterface $logger,
        BookRepository $bookRepository,
    )
    {
        parent::__construct($logger);
        $this->bookRepository = $bookRepository;
    }
}