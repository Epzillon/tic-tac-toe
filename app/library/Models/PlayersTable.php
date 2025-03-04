<?php

namespace App\Models;

class PlayersTable extends AbstractTable
{
    protected function getTableName(): string
    {
        return 'players';
    }

    /**
     * Retrieve leaderboard by grid size.
     * 
     * @param int $gridSize The grid size to display leaderboard for
     */
    public function getLeaders(int $gridSize): array
    {
        return $this->executeSql(
            "
                SELECT
                    name,
                    play_time_seconds,
                    grid_size
                FROM players
                WHERE
                    grid_size = :grid_size
                ORDER BY play_time_seconds ASC
                LIMIT 20
            ",
            [
                ':grid_size' => $gridSize
            ]
        );
    }

    public function addRow(string $name, int $gridSize, int $playTimeSeconds, string $date): void
    {
        $this->executeSql(
            "
                INSERT INTO players
                    (name, grid_size, play_time_seconds, ctime)
                VALUE
                    (:name, :grid_size, :play_time_seconds, :date)
            ",
            [
                ':name' => $name,
                ':grid_size' => $gridSize,
                ':play_time_seconds' => $playTimeSeconds,
                ':date' => $date,
            ]
        );
    }
}
