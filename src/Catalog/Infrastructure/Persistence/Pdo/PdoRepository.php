<?php

namespace Bookshop\Catalog\Infrastructure\Persistence\Pdo;

use PDO;
use Bookshop\Catalog\Domain\Book\BookRepository;

class PdoRepository
{
    protected $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }
}
