<?php

namespace App\Models;

use App\Core\Database\Database;
use App\Core\Database\DatabaseInterface;

abstract class AbstractTable
{
    private DatabaseInterface $db;

    abstract protected function getTableName(): string;

    public function __construct()
    {
        $this->db = Database::getDatabase();
    }

    /**
     * @param string[] $whereConditions
     * @param array $bindParameters
     * @return int
     */
    public function getCount(array $whereConditions = [], array $bindParameters = []): int
    {
        $sql = "
            SELECT COUNT(*) AS count
            FROM {$this->getTableName()}
        ";

        if ($whereConditions) {
            $sql .= "\n WHERE \n";
            $sql .= implode(' AND ', $whereConditions);
        }

        $result = $this->db->executeSQL($sql, $bindParameters);

        return $result[0]['count'] ?? 0;
    }

    protected function executeSql(string $sql, array $bindParameters = []): array
    {
        return $this->db->executeSQL($sql, $bindParameters);
    }
}
