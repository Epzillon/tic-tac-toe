function makeMove(buttonId) {
  setButtonsValue(buttonId, 'X');
  makeOpponentsTurn();
}

function makeOpponentsTurn() {
  const matrix = [];

  let row = 1;
  let col = 1;
  let rowTexts = [];
  do {
    const buttonId = `#game_grid_${row}_${col}`;

    // Very end of the matrix.
    if ($(buttonId).length === 0 && col === 1) {
      break;
    }

    // End of the row.
    if ($(buttonId).length === 0) {
      matrix.push(rowTexts);
      row++;
      col = 1;
      rowTexts = [];
      continue;
    }

    rowTexts.push($(buttonId).text());
    col++;
  } while (true);

  $.ajax({
    url: '/index/opponents-turn',
    method: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({ matrix: matrix }),
    success: function (response) {

      let is_game_over = response.is_game_over;
      let is_player_win = response.is_player_win;
      let is_computer_win = response.is_computer_win;

      if (!is_game_over || is_computer_win) {
        let row = response.row + 1;
        let col = response.col + 1;
        const buttonId = `#game_grid_${row}_${col}`;
        setButtonsValue(buttonId, 'O');
      }

      if (is_game_over) {
        $('#game_grid button').prop("disabled",true);

        if (is_player_win) {
          alert('Congratulations, you won!');
        }
        else if (is_computer_win) {
          alert('Computer won!');
        }
        else {
          alert('Nobody won :(');
        }
      }
    },
    error: function (xhr, status, error) {
      console.error('Failed to send matrix:', error);
    }
  });
}

function setButtonsValue(buttonId, text) {
  $(buttonId).text(text);
  $(buttonId).prop("disabled",true);
}
