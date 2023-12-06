<?php

namespace Bookshop\Catalog\Infrastructure\Persistence\Pdo;

use PDO;

class PdoRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function connection(): PDO
    {
        return $this->connection;
    }
}
