<?php

namespace App\Controllers;

use App\Models\PlayersTable;
use App\Views\AbstractView;
use App\Views\JsonView;
use App\Views\LeaderboardsView;

class LeaderboardsController implements ControllerInterface
{
    public function indexAction(): AbstractView
    {
        $gridSize = intval($_GET["grid_size"] ?? null);

        $view = new LeaderboardsView();

        if ($gridSize && ($gridSize >= 3 && $gridSize <= 50)) {
            $leaderboard = (new PlayersTable())->getLeaderboard($gridSize);
            $view->gridSize = $gridSize;
            $view->leaderboards = [$leaderboard];
        } else {
            $leaderboards = (new PlayersTable())->getLeaderboards();
            $view->leaderboards = $leaderboards;
        }

        return $view;
    }
}
