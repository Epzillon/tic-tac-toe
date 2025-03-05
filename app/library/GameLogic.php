<?php

namespace App;

class GameLogic
{
    private array $matrix;

    public function __construct(array $matrix)
    {
        if (empty($matrix)) {
            throw new \LogicException('Matrix could not be empty.');
        }

        foreach ($matrix as $row) {
            if (!is_array($row)) {
                throw new \LogicException('Multidimensional matrix is expected.');
            }
            if (count($matrix) !== count($row)) {
                throw new \LogicException('Square matrix is expected.');
            }
        }

        if (count($matrix) < 3) {
            throw new \LogicException('Square matrix should be bigger than 2.');
        }

        $this->matrix = $matrix;
    }

    /**
     * Good enough for MVP.
     * No one will notice.
     * 
     * NOTE: Improvement through deletion of recursion and has more consistent perfomance due to being limited to the size of the matrix.
     */
    public function findBestMove(): array
    {
        $emptySlots = [];

        // Loops the grid once and adds all empty slots defined as a string to a list
        // Identifying strings are formatted as "r-{index}_c-{index}"
        // r denoting the row and c the column for each empty slot
        foreach ($this->matrix as $ridx => $row) {
            foreach ($row as $cidx => $col) {
                if ($this->matrix[$ridx][$cidx] === '') {
                    $emptySlots[] = "r-" . $ridx . "_c-" . $cidx;
                }
            }
        }

        // Retrieves a random row and column by applying regex on a random string from the list
        $chosenSpot = $emptySlots[rand(0, count($emptySlots) -1)];
        // Improve performance further by implementing regex instead of exploding strings multiple times
        preg_match_all('/[0-9]+/', $chosenSpot, $matches);

        return [intval($matches[0][0]), intval($matches[0][1])];
    }

    public function setComputersMove(int $row, int $col): void
    {
        $this->matrix[$row][$col] = 'O';
    }

    public function isGameOver(): bool
    {
        return !$this->isFreeCellsLeft() || $this->doWeHaveWinner();
    }

    public function isFreeCellsLeft(): bool
    {
        for ($col = 0; $col < count($this->matrix); $col++) {
            for ($row = 0; $row < count($this->matrix); $row++) {
                if ($this->matrix[$col][$row] === '') {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * I just copypasted what ChatGPT gave me. Have no idea how it's working.
     * Need to write tests... Maybe.
     */
    public function doWeHaveWinner(): bool
    {
        // Check rows
        for ($i = 0; $i < count($this->matrix); $i++) {
            if (count(array_unique($this->matrix[$i])) === 1 && $this->matrix[$i][0] !== '') {
                return true;
            }
        }

        // Check columns
        for ($col = 0; $col < count($this->matrix); $col++) {
            $column = [];
            for ($row = 0; $row < count($this->matrix); $row++) {
                $column[] = $this->matrix[$row][$col];
            }
            if (count(array_unique($column)) === 1 && $column[0] !== '') {
                return true;
            }
        }

        // Check main diagonal
        $mainDiagonal = [];
        for ($i = 0; $i < count($this->matrix); $i++) {
            $mainDiagonal[] = $this->matrix[$i][$i];
        }
        if (count(array_unique($mainDiagonal)) === 1 && $mainDiagonal[0] !== '') {
            return true;
        }

        // Check anti-diagonal
        $antiDiagonal = [];
        for ($i = 0; $i < count($this->matrix); $i++) {
            $antiDiagonal[] = $this->matrix[$i][count($this->matrix) - $i - 1];
        }
        if (count(array_unique($antiDiagonal)) === 1 && $antiDiagonal[0] !== '') {
            return true;
        }

        // No winner
        return false;
    }
}
