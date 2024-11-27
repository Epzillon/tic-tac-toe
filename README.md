# Tic-tac-toe

Tic-tac-toe is a paper-and-pencil game for two players who take turns marking the spaces in a three-by-three grid with X or O.
The player who succeeds in placing three of their marks in a horizontal, vertical, or diagonal row is the winner.

## Preamble

You have received this unfinished project that the company must present to customers tomorrow.

Minimum requirements:
- The player can choose the grid size (N).
- The player always starts first with the "X" mark.
- The computer places "O" on the grid randomly.
- The player who succeeds in placing N of their marks in a horizontal, vertical, or diagonal row is the winner.
- The player loses if there are no more free cells left.
- The winning player's details must be saved to the database.
- At the end of the game, a leaderboard must be displayed:
  - The top 20 players should be shown.
  - The total number of players should be shown.
  - The displayed players should be sorted by grid size and playtime.

Some functionality is already working, but some is not. You need to:
- Complete the remaining tasks.
- Create a PR with all the changes.

NB! There are a few important things to mention:
1. You are now the lead developer and can make any changes you think are necessary.
2. A frontend developer hasn't been hired yet, and the customer has been notified that the solution might not look perfect from a frontend perspective. However, all backend development efforts contributing to the frontend will be taken into account.
Good luck!

### Task #1
Build the leaderboard according to the requirements.
Currently, it only displays some test values.

### Task #2
The player's name should be saved and displayed on the leaderboard if they win.
Currently, this feature only includes a table in the database, with no integration.

### Task #3
Rewrite the computer's move logic to make it less resource-intensive.
The current recursive random implementation is inefficient.

## Installation

```bash
    docker-compose up -d
    docker exec -ti tic_tac_toe_app bash
    composer install --dev
    cp ./configs/example.config.php ./configs/config.php
```

After that site will be available by url http://localhost:34580/
