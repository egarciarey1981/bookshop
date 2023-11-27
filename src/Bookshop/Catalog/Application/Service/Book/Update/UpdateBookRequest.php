<?php

namespace Bookshop\Catalog\Application\Service\Book\Update;

final class UpdateBookRequest
{
    private string $id;
    private string $title;
    private array $genreIds;

    public function __construct(
        string $id,
        string $title,
        array $genreIds,
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->genreIds = $genreIds;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function genreIds(): array
    {
        return $this->genreIds;
    }
}
