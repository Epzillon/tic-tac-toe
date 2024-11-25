<?php

namespace App;

class GameLogic
{
    public function __construct(
        private array $matrix,
    ) {
    }

    public function findBestMove(array $matrix): array
    {
        $row = rand(0, count($matrix) - 1);
        $col = rand(0, count($matrix) - 1);

        if ($matrix[$row][$col] === '') {
            return [$row, $col];
        }

        return $this->findBestMove($matrix);
    }

    public function setMove(int $row, int $col): void
    {
        $this->matrix[$row][$col] = 'O';
    }

    public function isGameOver(): bool
    {
        return !$this->isFreeCellsLeft() || $this->isLastMoveWin();
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

    public function isLastMoveWin(): bool
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
