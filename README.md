# Tic-tac-toe

Tic-tac-toe is a paper-and-pencil game for two players who take turns marking the spaces in a three-by-three grid with X or O.
The player who succeeds in placing three of their marks in a horizontal, vertical, or diagonal row is the winner.

## Preamble

You have received this unfinished project that the company must present to customers tomorrow.

Minimum requirements:
- The player can choose the grid size (N).
- Man always starts first with "X" mark.
- The computer can place "O" randomly.
- The player who succeeds in placing N of their marks in a horizontal, vertical, or diagonal row is the winner.
- The player loses if there are no more free cells left.
- The winning player must be saved to database.
- At the end of the game, a leaderboard should be shown:
  - Top 20 players should be shown.
  - Total amount of players should be shown.
  - Shown players should be sorted by grid size and play time.

Something is already working, something is not. You need to:
- Complete the remaining tasks
- Create PR with all changes.

NB! There are few things are important ot mention:
1. You are now the lead developer and can make any changes you think are necessary.
2. A frontend developer wasn't hired yet and customer was notified that solution could look not perfect from the frontend perspective. But all the efforts of the backend developer in this part will be taken into account.

Good luck!

### Task #1

Build the Leaderboard regarding the requirements.
Right now it only shows some test values.

### Task #2

Players name should be saved and shown in the leaderboard in case player won.
Right now we don't have such feature only a table in a database.

### Task #3

The computer's move logic should be rewritten to something less resource intensive.
Recursive random is not working so good.

## Installation

```bash
    docker-compose up -d
    docker exec -ti tic_tac_toe_app bash
    composer install --dev
    cp ./configs/example.config.php ./configs/config.php
```

After that site will be available by url http://localhost:34580/
