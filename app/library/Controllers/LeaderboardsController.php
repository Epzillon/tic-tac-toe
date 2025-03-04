<?php

namespace App\Controllers;

use App\Models\PlayersTable;
use App\Views\AbstractView;
use App\Views\LeaderboardsView;

class LeaderboardsController implements ControllerInterface
{
    public function indexAction(): AbstractView
    {
        $view = new LeaderboardsView();

        $leaderboards = (new PlayersTable())->getLeaderboards();
        $view->leaderboards = $leaderboards;

        return $view;
    }

}
