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
     * 
     * @return array{array{name: string, play_time_seconds: int, grid_size: int}}
     */
    public function getLeaders(int $gridSize): array
    {
        return $this->executeSql(
            "
                SELECT
                    name,
                    play_time_seconds
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

    /**
     * Retrieves the distinct grid sizes from played games.
     * 
     * @return array{int}
     */
    public function getDistinctGridSizes(): array {
        $gridSizes = $this->executeSql(
            "
            SELECT
            DISTINCT grid_size
            FROM players
            ORDER BY grid_size DESC
            "
        );

        // Map to one-dimensional array
        return array_map(fn($gridSizeItem) => $gridSizeItem['grid_size'], $gridSizes);
    }

    /**
     * Return leaderboards for all currently existing grid sizes where the key for each leaderboard array is the corresponding grid size of the leaderboard.
     *
     * @return array<int, array{name: string, play_time_seconds: int}>
     */
    public function getLeaderboards(): array {
        $gridSizes = $this->getDistinctGridSizes();
        $leaderboards = [];

        // OPTIMIZE: For larger data sets this would be refactored to run parallel queries.
        foreach ($gridSizes as $gridSize) {
            $leaderboards[$gridSize] = $this->getLeaders($gridSize);
        }

        return $leaderboards;
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
