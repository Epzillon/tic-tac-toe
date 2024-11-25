# Tic-tac-toe

Tic-tac-toe is a paper-and-pencil game for two players who take turns marking the spaces in a three-by-three grid with X or O.
The player who succeeds in placing three of their marks in a horizontal, vertical, or diagonal row is the winner.

## Task

You have received this unfinished project that the company must present to customers tomorrow.
You have minimum requirements, which sound like this:
- The player can choose the grid size (N).
- Man always starts first with "X" mark.
- The computer should place the "O" randomly, but next to the "X".
- The player who succeeds in placing N of their marks in a horizontal, vertical, or diagonal row is the winner.
- The game ends when there is no more free cell left.
- At the end of the game, a leaderboard should be shown for the selected grid size:
  - Top 10 players should be shown.
  - Total amount of players should be shown.
  - Shown players should be sorted by play time.

NB! A frontend developer wasn't hired yet and customer was notified that solution could look not perfect from the frontend perspective.
But all the efforts of the backend developer in this part will be taken into account.

## Installation

```bash
    docker-compose up -d
    docker exec -ti tic_tac_toe_app bash
    composer install --dev
    cp ./configs/example.config.php ./configs/config.php
```

After that site will be available by url http://localhost:34580/
