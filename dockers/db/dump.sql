CREATE TABLE players
(
    player_id         INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Player ID',
    name              VARCHAR(100) NOT NULL COMMENT 'Player name',
    grid_size         INT NOT NULL COMMENT 'Grid size',
    play_time_seconds INT NOT NULL COMMENT 'Play time in seconds',
    ctime             DATETIME NOT NULL COMMENT 'Date',
    PRIMARY KEY (player_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

INSERT INTO players
    (player_id, name, grid_size, play_time_seconds, ctime)
VALUES
    (1, 'Player 1', 10, 40, '2023-09-20 14:01:23'),
    (2, 'Alex', 10, 244, '2023-09-21 15:41:51'),
    (3, 'Maria', 10, 100, '2023-09-22 13:22:12'),
    (4, 'User123', 5, 10, '2023-09-23 01:51:01')
;
