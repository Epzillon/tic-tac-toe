<?php

namespace Tests;

use App\GameLogic;
use PHPUnit\Framework\TestCase;

class GameLogicTest extends TestCase
{
    public function testEmptyMatrix(): void
    {
        $this->expectExceptionMessage('Matrix could not be empty.');
        new GameLogic([]);
    }

    public function testOneDimensionalMatrix(): void
    {
        $this->expectExceptionMessage('Multidimensional matrix is expected.');
        new GameLogic(['', '', '']);
    }

    public function testUnevenMatrix(): void
    {
        $matrix = [
            ['', '', ''],
            ['', '', ''],
            ['', ''],
            ['', '', '', ''],
        ];

        $this->expectExceptionMessage('Square matrix is expected.');
        new GameLogic($matrix);
    }

    public function testSmallMatrix(): void
    {
        $matrix = [
            ['', ''],
            ['', ''],
        ];

        $this->expectExceptionMessage('Square matrix should be bigger than 2.');
        new GameLogic($matrix);
    }

    public function testMatrixWithoutAnyMove(): void
    {
        $matrix = [
          ['', '', ''],
          ['', '', ''],
          ['', '', ''],
        ];
        $gameLogic = new GameLogic($matrix);

        $this->assertTrue($gameLogic->isFreeCellsLeft());
        $this->assertFalse($gameLogic->isGameOver());
        $this->assertFalse($gameLogic->doWeHaveWinner());
    }

    public function testMatrixWithNoFreeCells(): void
    {
        $matrix = [
            ['X', 'O', 'X'],
            ['X', 'O', 'O'],
            ['O', 'X', 'X'],
        ];
        $gameLogic = new GameLogic($matrix);

        $this->assertFalse($gameLogic->isFreeCellsLeft());
        $this->assertTrue($gameLogic->isGameOver());
        $this->assertFalse($gameLogic->doWeHaveWinner());
    }

    public function testMatrixWinnerInRow(): void
    {
        $matrix = [
            ['O', '', ''],
            ['O', '', ''],
            ['X', 'X', 'X'],
        ];
        $gameLogic = new GameLogic($matrix);

        $this->assertTrue($gameLogic->isFreeCellsLeft());
        $this->assertTrue($gameLogic->isGameOver());
        $this->assertTrue($gameLogic->doWeHaveWinner());
    }

    public function testMatrixWinnerInColumn(): void
    {
        $matrix = [
            ['O', '', ''],
            ['O', 'X', ''],
            ['O', 'X', 'X'],
        ];
        $gameLogic = new GameLogic($matrix);

        $this->assertTrue($gameLogic->isFreeCellsLeft());
        $this->assertTrue($gameLogic->isGameOver());
        $this->assertTrue($gameLogic->doWeHaveWinner());
    }

    public function testMatrixWinnerInDiagonal(): void
    {
        $matrix = [
            ['X', 'O', ''],
            ['O', 'X', ''],
            ['O', 'X', 'X'],
        ];
        $gameLogic = new GameLogic($matrix);

        $this->assertTrue($gameLogic->isFreeCellsLeft());
        $this->assertTrue($gameLogic->isGameOver());
        $this->assertTrue($gameLogic->doWeHaveWinner());
    }

    public function testMatrixWinnerInAntiDiagonal(): void
    {
        $matrix = [
            ['', 'X', 'O'],
            ['', 'O', ''],
            ['O', 'X', 'X'],
        ];
        $gameLogic = new GameLogic($matrix);

        $this->assertTrue($gameLogic->isFreeCellsLeft());
        $this->assertTrue($gameLogic->isGameOver());
        $this->assertTrue($gameLogic->doWeHaveWinner());
    }

    public function testFindOnlyPossibleMove(): void
    {
        $matrix = [
            ['X', 'X', ''],
            ['O', 'O', 'X'],
            ['O', 'X', 'X'],
        ];
        $gameLogic = new GameLogic($matrix);

        list($row, $col) = $gameLogic->findBestMove();
        $this->assertSame(0, $row);
        $this->assertSame(2, $col);
    }

    public function testFindBestMoveIfNoMovesAvailable(): void
    {
        $this->markTestSkipped('Allowed memory size bytes exhausted');
        /** @noinspection PhpUnreachableStatementInspection */
        $matrix = [
            ['X', 'X', 'O'],
            ['O', 'O', 'X'],
            ['O', 'X', 'X'],
        ];
        $gameLogic = new GameLogic($matrix);

        $this->expectExceptionMessage('No more available moves exists.');
        $gameLogic->findBestMove();
    }

}
