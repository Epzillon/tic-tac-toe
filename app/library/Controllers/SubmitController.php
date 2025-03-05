<?php

namespace App\Controllers;

use App\Models\PlayersTable;
use App\Views\AbstractView;
use App\Views\JsonView;
use DateTime;

class SubmitController implements ControllerInterface
{
    public function indexAction(): AbstractView
    {
        if (!(isset($_POST["player_name"]) && isset($_POST["grid_size"]) && isset($_POST["time"]))) {
            header("Location: /leaderboards");
        }

        $playerName = htmlspecialchars($_POST["player_name"]);
        $gridSize = htmlspecialchars($_POST["grid_size"]);
        $time = htmlspecialchars($_POST["time"]);

        (new PlayersTable())->addRow($playerName, $gridSize, $time, (new DateTime())->format("Y-m-d H:i:s"));

        // TODO: Implement better redirect functionality in Controller - currently REQUIRED to return a view
        header("Location: /leaderboards?grid_size=" . $gridSize);

        return new JsonView();
    }
}
