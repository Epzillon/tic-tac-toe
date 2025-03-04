<?php

namespace App\Views;

class LeaderboardView extends AbstractView
{
    /** @var array[][] */
    public array $leaderboards;

    public function __construct()
    {
        $this->setTitle("Leaderboard");
    }

    public function render(): void
    {
        include __DIR__ . '/leaderboard.phtml';
    }
}
