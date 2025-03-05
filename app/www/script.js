let timer;
let timeElapsed = 0;
let curGridSize;

function makeMove(buttonId, gridSize) {
    if (!timer) {
        timer = setInterval(() => {
            timeElapsed++;
        }, 1000);
    }

    if (!curGridSize) {
        curGridSize = gridSize;
    }

    setButtonsValue(buttonId, 'X');
    makeOpponentsTurn();
}

/**
 * Builds and appends a result div, displaying information about the results of the game.
 * 
 * @param {String} result   The result of the game as a string ("win"|"loss"|"tie")
 * @param {Number} gridSize The gird size of the game
 */
async function displayResults(result, gridSize, time) {
    // Build result container
    let resultContainer = await buildResultContainer(result, gridSize);

    // Add buttons for retry and leaderboards
    let buttonsContainer = buildButtonContainer(gridSize);
    resultContainer.appendChild(buttonsContainer);

    let resultDiv = document.getElementById("results");
    resultDiv.appendChild(resultContainer);

    // Allow result submission on win
    if (result === "win") {
        let submitContainer = buildSubmitContainer(gridSize, time);
        resultDiv.appendChild(submitContainer);
    }

    resultDiv.style.display = "inline-block";
}

function buildSubmitContainer(gridSize, time) {
    let submitContainer = document.createElement("div");
    let submitHeading = document.createElement("h1");
    let submitTime = document.createElement("p");
    let submitDescription = document.createElement("p");
    let submitForm = buildSubmitForm(gridSize, time);
    
    submitContainer.id = "submit-container";
    submitHeading.innerHTML = "Submit your score!"
    submitTime.innerHTML = "Your time was " + time + " seconds!";
    submitDescription.innerHTML = "Fill out the form and press \"Submit\" to submit your score!"

    submitContainer.appendChild(submitHeading)
    submitContainer.appendChild(submitTime);
    submitContainer.appendChild(submitDescription);
    submitContainer.appendChild(submitForm);

    return submitContainer;
}

function buildSubmitForm(gridSize, time) {
    let submitForm = document.createElement("form");
    let inputLabel = document.createElement("label");
    let playerGridSizeInput = document.createElement("input");
    let playerTimeInput = document.createElement("input");
    let playerNameInput = document.createElement("input");
    let submitBtn = document.createElement("input");

    submitForm.action = "/submit";
    submitForm.method = "POST";
    inputLabel.innerHTML = "Player Name:";

    playerGridSizeInput.id = "grid_size";
    playerGridSizeInput.name = "grid_size";
    playerGridSizeInput.type = "number";
    playerGridSizeInput.hidden = true;
    playerGridSizeInput.required = true;
    playerGridSizeInput.value = gridSize;

    playerTimeInput.id = "time";
    playerTimeInput.name = "time";
    playerTimeInput.type = "number";
    playerTimeInput.hidden = true;
    playerTimeInput.required = true;
    playerTimeInput.value = time;

    playerNameInput.id = "player_name";
    playerNameInput.name = "player_name";
    playerNameInput.type = "text";
    playerNameInput.placeholder = "Your epic player name..."
    playerNameInput.required = true;
    submitBtn.type = "submit"
    submitBtn.value = "Submit";

    submitForm.appendChild(inputLabel);
    submitForm.appendChild(playerNameInput);
    submitForm.appendChild(playerGridSizeInput);
    submitForm.appendChild(playerTimeInput);
    submitForm.appendChild(submitBtn);

    return submitForm;
}

/**
 * Builds and returns the outermost part of the result div, including title and result text dependent on the game results.
 * 
 * @param {String} result   The result of the game as a string ("win"|"loss"|"tie")
 * @param {Number} gridSize The grid size of the game as an integer
 * 
 * @returns {HTMLElement}   The result container as an HTMLElement
 */
async function buildResultContainer(result, gridSize) {
    let container = document.createElement("div");
    let heading = document.createElement("h1")
    let resultText = document.createElement("p");
    let leaderboardHeading = document.createElement("h1");
    let leaderboard = await buildLeaderboardElement(gridSize);

    container.id = "result-container";
    heading.innerHTML = "Results";
    resultText.innerHTML = getResultText(result);
    leaderboardHeading.innerHTML = "Leaderboards:"
    leaderboardHeading.className = "leaderboard-heading";

    container.appendChild(heading);
    container.appendChild(resultText);
    container.appendChild(leaderboardHeading);
    container.appendChild(leaderboard);

    return container;
}

/**
 * Fetches and returns the leaderboard element as an Element. Can result in an HTMLElement only containing a presentable error message if something goes wrong.
 * 
 * NOTE: Usually in frameworks this would be done way different since you could just fetch the data and easily display an element pre-defined in a view. In this case
 * we need to build the entire table from scratch using Vanilla JS, which is way more tedious. I wanted to mention somewhere that my initial approach was to set up a
 * JSON route in the Controller and do a regular POST request and just build the entire table by looping through the retrieved data, but in this case it is more efficient
 * to just get the rendered HTML since the structure of this MVC is formed well enough that each ViewModel is individualized and does not render the entire page, thus
 * leaving us with (almost) just the presentable data we want. I therefore opted to a more "out-of-the-box" solution of simply fetching the entire HTML and appending
 * the required element here.
 * 
 * @param {*} gridSize The grid size to fetch the leaderboard for.
 * 
 * @returns {Element|HTMLElement}   An HTML element either containing the leaderboard or an error message if the request failed.
 */
async function buildLeaderboardElement(gridSize) {
    let promisedData = getLeaderboardHtml(gridSize);

    try {
        let html = await promisedData;
        let tempDiv = document.createElement("div");
        tempDiv.innerHTML = html;
        let leaderboard = tempDiv.querySelector("#leaderboards-container");

        return leaderboard;
    } catch (error) {
        let errorMessage = document.createElement("p");
        errorMessage.innerHTML = "Sorry, something went wrong while fetching the leaderboards..."
        
        return errorMessage;
    }
}

function buildButtonContainer(gridSize) {
    let btnContainer = document.createElement("div");
    let retryBtn = document.createElement("button");
    let leaderboardBtn = document.createElement("button");

    btnContainer.className = "btn-container"

    retryBtn.innerHTML = "Retry";
    retryBtn.onclick = () => {
        window.location.reload();
    }

    leaderboardBtn.innerHTML = "Show Leaderboards";
    leaderboardBtn.onclick = () => {
        window.location.href = "/leaderboards?grid_size=" + gridSize;
    }

    btnContainer.appendChild(retryBtn);
    btnContainer.appendChild(leaderboardBtn);

    return btnContainer;
}

/**
 * Returns a string with appropriate result text based on the game results.
 * 
 * @param {String} result   The result of the game as a string ("win"|"loss"|"tie")
 * 
 * @returns {String}        The appropriate result text
 */
function getResultText(result) {
    if (result === "win") {
        return "Congratulations, you won!";
    } else if (result === "loss") {
        return "You lost!";
    } else if (result === "tie") {
        return "It's a tie! Nobody wins!";
    }
}

/**
 * Fetches the leaderboard HTML for a specified grid size or all leaderboards if grid size is unspecified.
 * 
 * @param {Number} [gridSize] The grid size as an integer for which leaderboard to fetch, if unspecified fetches all leaderboards
 * 
 * @returns {Promise<any>}  A promise that either contains the leaderboard data or gets rejected due to a server error.
 */
function getLeaderboardHtml(gridSize) {
    return fetch(
        gridSize ? '/leaderboards?grid_size=' + gridSize : "/leaderboards",
        {
          method: "GET",
          headers: {
            "Accept": "text/html",
          },
        }
    )
    .then((response) => {
        if (response.ok) {
            return response.text();
        }

        return Promise.reject(response);
    });
}

function makeOpponentsTurn() {
  const matrix = [];

  let row = 1;
  let col = 1;
  let rowTexts = [];
  do {
    const buttonId = `game_grid_${row}_${col}`;

    // Very end of the matrix.
    if (document.getElementById(buttonId) == null && col === 1) {
      break;
    }

    // End of the row.
    if (document.getElementById(buttonId) == null) {
      matrix.push(rowTexts);
      row++;
      col = 1;
      rowTexts = [];
      continue;
    }

    rowTexts.push(document.getElementById(buttonId).innerText);
    col++;
  } while (true);

  fetch(
    '/index/opponents-turn',
    {
      method: "POST",
      headers: {
        "Accept": "application/json",
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ matrix: matrix }),
    }
  )
  .then((response) => {
    if (response.ok) {
      return response.json();
    }
    return Promise.reject(response); // 2. reject instead of throw
  })
    .then((json) => {
      let is_game_over = json.is_game_over;
      let is_player_win = json.is_player_win;
      let is_computer_win = json.is_computer_win;

      if (!is_game_over || !is_player_win) {
        let row = json.row + 1;
        let col = json.col + 1;
        const buttonId = `game_grid_${row}_${col}`;
        setButtonsValue(buttonId, 'O');
      }

      if (is_game_over) {
        clearInterval(timer);

        if (is_player_win) {
            displayResults("win", curGridSize, timeElapsed);
        }
        else if (is_computer_win) {
            displayResults("loss", curGridSize, timeElapsed);
        }
        else {
            displayResults("tie", curGridSize, timeElapsed);
        }
      }
    })
}

function setButtonsValue(buttonId, text) {
  document.getElementById(buttonId).innerText = text;
  document.getElementById(buttonId).disabled = true;
}