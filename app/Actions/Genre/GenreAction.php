<?php

declare(strict_types=1);

namespace App\Actions\Genre;

use App\Actions\Action;
use Bookshop\Catalog\Domain\Model\Genre\GenreRepository;
use Psr\Log\LoggerInterface;

abstract class GenreAction extends Action
{
    protected GenreRepository $genreRepository;

    public function __construct(
        LoggerInterface $logger,
        GenreRepository $genreRepository,
    ) {
        parent::__construct($logger);
        $this->genreRepository = $genreRepository;
    }
}
