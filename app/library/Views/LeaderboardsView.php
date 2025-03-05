<?php

namespace App\Views;

class LeaderboardsView extends AbstractView
{
    /** @var array[][] */
    public array $leaderboards;
    public int $gridSize;

    public function __construct()
    {
        $this->setTitle("Leaderboards");
    }

    public function render(): void
    {
        include __DIR__ . '/leaderboards.phtml';
    }
}
