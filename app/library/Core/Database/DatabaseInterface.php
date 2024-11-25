<?php

namespace App\Core\Database;

interface DatabaseInterface
{
    public function executeSQL(string $sql, array $bindParameters = []): array;
}
