<?php

namespace App\Controllers;

use App\GameLogic;
use App\Views\IndexView;
use App\Views\AbstractView;
use App\Views\JsonView;

class IndexController implements ControllerInterface
{
    public function indexAction(): AbstractView
    {
        $gridSize = $this->getGridSize();

        $view = new IndexView();
        $view->gridSize = $gridSize;

        return $view;
    }

    private function getGridSize(): int
    {
        // Simple validation
        $gridSize = intval($_GET['grid_size'] ?? 3);
        if ($gridSize < 3 || $gridSize > 50) {
            $gridSize = 3;
        }
        return $gridSize;
    }

    /**
     * It is used in Ajax requests.
     * @noinspection PhpUnused
     */
    public function opponentsTurnAction(): AbstractView
    {
        // Todo: Ask on StakeOverflow if it's good enough.
        $request_json = file_get_contents('php://input');
        $request = json_decode($request_json, true);

        $matrix = $request['matrix'] ?? [];

        $gameLogic = new GameLogic($matrix);

        $is_game_over = $gameLogic->isGameOver();
        $is_player_win = $gameLogic->isLastMoveWin();
        $is_computer_win = false;
        $row = 0;
        $col = 0;
        if (!$is_player_win && $gameLogic->isFreeCellsLeft()) {
            list($row, $col) = $gameLogic->findBestMove($matrix);
            $gameLogic->setMove($row, $col);
            $is_game_over = $gameLogic->isGameOver();
            $is_computer_win = $gameLogic->isLastMoveWin();
        }

        $view = new JsonView();
        $view->data = [
            'is_game_over' => $is_game_over,
            'is_player_win' => $is_player_win,
            'is_computer_win' => $is_computer_win,
            'row' => $row,
            'col' => $col,
        ];
        return $view;
    }


}
