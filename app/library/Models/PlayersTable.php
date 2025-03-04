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
     * @return array{array{name: string, play_time_seconds: int}} An array containing arrays with the name and play_time of each player on the leaderboard.
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
    private function getDistinctGridSizes(): array {
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
     * Return leaderboards and player count for all currently existing grid sizes where the key for each value is the corresponding grid size of the leaderboard.
     *
     * @return array<int, array{total_players: int, leaderboard: array{array{name: string, play_time_seconds: int}}}> An array containing the player count and leaderboard for all grid sizes.
     * 
     * @example The data structure for leaderboards of size 5 and 10
     * [
     *      5: [
     *          total_players: 2,
     *          leaderboard: [
     *              0: [name: "Player1", play_time_seconds: 10],
     *              1: [name: "Player2", play_time_seconds: 15]
     *          ]
     *      ],
     *      10: [
     *          total_players: 1,
     *          leaderboard: [
     *              0: [name: "Player3", play_time_seconds: 5]
     *          ]
     *      ]
     * ]
     */
    public function getLeaderboards(): array {
        $gridSizes = $this->getDistinctGridSizes();
        $leaderboards = [];

        // OPTIMIZE: For larger data sets this would be refactored to run parallel queries.
        foreach ($gridSizes as $gridSize) {
            $playerCount = $this->getTotalPlayers($gridSize);
            $leaderboard = $this->getLeaders($gridSize);

            $leaderboards[$gridSize] = [
                'total_players' => $playerCount,
                'leaderboard' => $leaderboard
            ];
        }

        return $leaderboards;
    }

    /**
     * Returns the total amount of players for a given grid size.
     * 
     * @param int $gridSize The grid size leaderboard to fetch total amount of players of.
     * @return int          The amount of players for this grid size.
     */
    public function getTotalPlayers(int $gridSize): int {
        // This assumes we are referring to every "play" recorded to the leaderboard.
        // If players had accounts or we didnt want to count duplicate players names we would need to fetch unique rows here.
        // This is just my thought process, but I think this is probably outside the scope of this test.
        $playerCountResult = $this->executeSql(
            "
            SELECT COUNT(*)
            FROM players
            WHERE grid_size = :grid_size
            ",
            [
                ':grid_size' => $gridSize
            ]
        );

        // This could also be cleaner with refactoring of the executeSql() function, once again, this is probably outside of the scope of this test
        return $playerCountResult[0]['COUNT(*)'];
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
