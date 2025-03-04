<?php

namespace App\Controllers;

use App\Models\PlayersTable;
use App\Views\AbstractView;
use App\Views\LeaderboardView;

class LeaderboardController implements ControllerInterface
{
    public function indexAction(): AbstractView
    {
        $view = new LeaderboardView();

        $leaderboards = (new PlayersTable())->getLeaderboards();
        $view->leaderboards = $leaderboards;

        return $view;
    }

}
